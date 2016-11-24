<template>

    <div v-show="columnsSet">
        <table :class="[{'vuetable': true}, css.tableClass]">
            <thead>
            <tr>
                <template v-for="field in fields">
                    <template v-if="field.visible">
                        <template v-if="isSpecialField(field.name)">
                            <th v-if="extractName(field.name) == '__checkbox'" :class="[field.titleClass || '']">
                                <input type="checkbox" @change="toggleAllCheckboxes(field.name, $event)">
                            </th>
                            <th v-if="extractName(field.name) == '__component'"
                                @click="orderBy(field, $event)"
                                :class="[field.titleClass, {'sortable': isSortable(field)}]"
                                v-html="field.title || ''">
                                <i v-if="isCurrentSortField(field) && field.title"
                                   :class="sortIcon(field)"
                                   :style="{opacity: sortIconOpacity(field)}"></i>
                            </th>
                            <th v-if="extractName(field.name) == '__relation'"
                                :class="[field.titleClass, {'sortable': isSortable(field)}]"
                                v-html="getRelationTitle(field.name)">
                            </th>
                            <th v-if="extractName(field.name) == '__action'"
                                :class="[field.titleClass, {'sortable': isSortable(field)}]"
                                v-html="getRelationTitle(field.name)">
                            </th>
                            <th v-if="extractName(field.name) == '__link'"
                                :class="[field.titleClass, {'sortable': isSortable(field)}]"
                                v-html="getRelationTitle(field.name)">
                            </th>
                            <th v-if="notIn(extractName(field.name), ['__link', '__action', '__checkbox', '__component', '__relation'])"
                                :id="'_' + extractArgs(field.name)" class="[field.titleClass || '']"
                                v-html="field.title || ''">
                            </th>

                        </template>
                        <template v-else>
                            <th @click="orderBy(field, $event)"
                                :id="'_' + field.name"
                                :class="[field.titleClass,  {'sortable': isSortable(field)}]">
                                {{ getTitle(field) }}&nbsp;
                                <i v-if="isCurrentSortField(field)" :class="sortIcon(field)"
                                   :style="{opacity: sortIconOpacity(field)}"></i>
                            </th>
                        </template>
                    </template>
                </template>
            </tr>
            </thead>
            <tbody v-cloak>
            <template v-for="(item, index) in tableData">
                <tr @click="onRowClicked(item, $event)" :render="onRowChanged(item)" :class="onRowClass(item, index)">
                    <template v-for="field in fields">
                        <template v-if="field.visible">
                            <template v-if="isSpecialField(field.name)">
                                <td v-if="extractName(field.name) == '__sequence'"
                                    :class="[{'vuetable-sequence': true}, field.dataClass]"
                                    v-html="tablePagination.from + index">
                                </td>
                                <td v-if="extractName(field.name) == '__checkbox'"
                                    :class="[{'vuetable-checkboxes': true}, field.dataClass]">
                                    <input type="checkbox"
                                           @change="toggleCheckbox(item, field.name, $event)"
                                           :checked="rowSelected(item, field.name)">
                                </td>
                                <td v-if="extractName(field.name) === '__component'" :class="field.dataClass">
                                    <component :is="extractArgs(field.name)" :row-data="item"></component>
                                </td>
                                <td v-if="extractName(field.name) === '__relation'"
                                    :class="field.dataClass">
                                    <a v-html="getRelationHtml(field.name, item)"
                                       :href="getRelationHref(field.name, item)"
                                       @click.stop.prevent="redirectToRelation(field.name, item)"></a>
                                </td>
                                <td v-if="extractName(field.name) === '__action'"
                                    :class="field.dataClass">
                                    <button v-html="getRelationHtml(field.name, item)" class="btn btn-default"
                                       @click.stop.prevent="submitButtonAction(field.name, item)"></button>
                                </td>
                                <td v-if="extractName(field.name) === '__link'"
                                    :class="field.dataClass">
                                    <button v-html="getRelationHtml(field.name, item)" class="btn btn-default"
                                            @click.stop.prevent="submitLinkAction(field.name, item)"></button>
                                </td>
                            </template>
                            <template v-else>
                                <td v-if="hasCallback(field)" :class="field.dataClass"
                                    @click="onCellClicked(item, field, $event)"
                                    @dblclick="onCellDoubleClicked(item, field, $event)"
                                    v-html="callCallback(field, item)"
                                >
                                </td>
                                <td v-else :class="field.dataClass"
                                    @click="onCellClicked(item, field, $event)"
                                    @dblclick="onCellDoubleClicked(item, field, $event)"
                                    v-html="getObjectValue(item, field.name, '')"
                                >
                                </td>
                            </template>
                        </template>
                    </template>
                </tr>
                <template v-if="useDetailRow">
                    <tr v-if="isVisibleDetailRow(item[detailRowId])"
                        @click="onDetailRowClick(item, $event)"
                        :transition="detailRowTransition"
                        :class="[css.detailRowClass]"
                    >
                        <td :colspan="countVisibleFields">
                            <component :is="detailRowComponent" :row-data="item"></component>
                        </td>
                    </tr>
                </template>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script>
    import Vue from 'vue'
    import VueResource from 'vue-resource'
    Vue.use(VueResource)
    import Domain from '../../mixins/domain.vue'
    import Relation from '../../mixins/relation.vue'

    import VuetableExtensions from '../../mixins/vuetable_extensions.vue'
//    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination.vue';
//    import VuetablePaginationDropdown  from 'vuetable-2/src/components/VuetablePaginationDropdown.vue';
//    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo.vue';
//
//    Vue.component('vuetable-pagination', VuetablePagination)
//    Vue.component('vuetable-pagination-dropdown', VuetablePaginationDropdown)
//    Vue.component('vuetable-pagination-info', VuetablePaginationInfo)

    export default {

        name: 'pagination-info',
        mixins: [VuetableExtensions, Domain, Relation],

        props: {
            fields: {
                type: Array,
                required: true
            },
            loadOnStart: {
                type: Boolean,
                default: true
            },
            apiUrl: {
                type: String,
                default: ''
            },
            dataPath: {
                type: String,
                default: 'data'
            },
            paginationPath: {
                type: [String],
                default: 'links.pagination'
            },
            queryParams: {
                type: Object,
                default: function () {
                    return {
                        sort: 'sort',
                        page: 'page',
                        perPage: 'per_page'
                    }
                }
            },
            appendParams: {
                type: Object,
                default: function () {
                    return {}
                }
            },
            httpOptions: {
                type: Object,
                default: function () {
                    return {}
                }
            },
            perPage: {
                type: Number,
                default: function () {
                    return 10
                }
            },
            sortOrder: {
                type: Array,
                default: function () {
                    return []
                }
            },
            multiSort: {
                type: Boolean,
                default: function () {
                    return false
                }
            },
            multiSortKey: {
                type: String,
                default: 'alt'
            },
            rowClassCallback: {
                type: String,
                default: ''
            },
            detailRowId: {
                type: String,
                default: 'id'
            },
            detailRowComponent: {
                type: String,
                default: ''
            },
            detailRowTransition: {
                type: String,
                default: ''
            },
            css: {
                type: Object,
                default: function () {
                    return {
                        tableClass: 'ui selectable celled stackable attached table',
                        loadingClass: 'loading',
                        ascendingIcon: 'blue chevron up icon',
                        descendingIcon: 'blue chevron down icon',
                        detailRowClass: 'vuetable-detail-row',
                    }
                }
            },
            silent: {
                type: Boolean,
                default: false
            }
        },
        data: function () {
            return {
                eventPrefix: 'vuetable:',
                tableData: null,
                tablePagination: null,
                currentPage: 1,
                selectedTo: [],
                visibleDetailRows: [],

//                // Editing
                columnsSet: false,
                initialLoad: false,
                relations: [],
//                fields: [],

            }
        },
        created: function () {
            this.normalizeFields()
            if (this.loadOnStart) {
                this.loadData()
//                this.$nextTick(function () {
//                    console.log('initialLoad')
//                    this.initialLoad = true
//                })
            }
        },
        computed: {
            useDetailRow: function () {
                if (this.tableData && typeof this.tableData[0][this.detailRowId] === 'undefined') {
                    this.warn('You need to define "detail-row-id" in order for detail-row feature to work!')
                    return false
                }

                return this.detailRowComponent !== ''
            },
            countVisibleFields: function () {
                return this.fields.filter(function (field) {
                    return field.visible
                }).length
            }
        },
        methods: {

            submitLinkAction(fieldName, item)
            {
                var url = item[fieldName]['url']
                window.location.href = url
            },

            submitButtonAction(fieldName, item)
            {
                console.log('submitButtonAction:', fieldName, item)
//                alert(item[fieldName])

                var url = this.apiDomain + '/api/data/action';
                var request_options =  {
//                        name: item[fieldName]['btnName'],
                        action: item[fieldName]['actionMethod'],
                        _method: item[fieldName]['postMethod'],
                        urlId: item.id
                };

                this.$http.post(url, request_options)

                        .then((response) => {

                            console.log('Success - updating');
                            console.log(response);
                            eventHub.$emit('hide-errors', response)
                            eventHub.$emit('flash-message-response', response)


                        }, (response) => {

                            console.log('Error Response Data:');
                            console.log(response);
                            eventHub.$emit('error-response', response)

                        });
            },

            redirectToRelation(fieldName, item)
            {
//                var parentId = item.id
//                var url = this.siteDomain + item[fieldName]['path'];
                var relation = item[fieldName]
                this.redirectToChildRelation(item, relation)
            },

            getRelationHref(fieldName, item)
            {
                return item[fieldName]['childPath']
            },

            getRelationHtml(fieldName, item)
            {
                return item[fieldName]['actionName']
            },

//            getButtonTitle(fieldName, item)
//            {
//                return item[fieldName]['actionName']
//            },

//            getButtonHtml(fieldName, item)
//            {
//                return item[fieldName]['btnName']
//            },

            getRelationTitle(fieldName)
            {
                var title = this.extractArgs(fieldName)
                return title.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase()
                        + txt.substr(1).toLowerCase();});
//                return field.name
//                return field[field.name]['title']
            },

            normalizeFields: function () {

                console.log('normalizeFields:', this.fields)

                if (typeof(this.fields) === 'undefined') {
                    this.warn('You need to provide "fields" prop.')
                    return
                }

                var self = this
                var obj
                this.fields.forEach(function (field, i) {

//                    console.log('normalizeFields', field )

//                    if (field.hasOwnProperty("relationship")) {
//                        this.relations.push(field);
//                        obj = {
//                            name: '__relation:' + field.relationship,
//                            title: field.relationship,
//                            sortField: '',
//                            titleClass: '',
//                            dataClass: '',
//                            callback: '',
//                            visible: true,
//                            field: field,
//                        }
//                    }
//
//                    else
                    if (typeof (field) === 'string') {
                        obj = {
                            name: field,
                            title: self.setTitle(field),
                            titleClass: '',
                            dataClass: '',
                            callback: null,
                            visible: true,
                            field: field,
                        }
                    } else {
                        obj = {
                            name: field.name,
                            title: (field.title === undefined) ? self.setTitle(field.name) : field.title,
                            sortField: field.sortField,
                            titleClass: (field.titleClass === undefined) ? '' : field.titleClass,
                            dataClass: (field.dataClass === undefined) ? '' : field.dataClass,
                            callback: (field.callback === undefined) ? '' : field.callback,
                            visible: (field.visible === undefined) ? true : field.visible,
                            field: field,
                        }
                    }
                    Vue.set(self.fields, i, obj)
                })
            },
            setTitle: function (str) {
                if (this.isSpecialField(str)) {
                    return ''
                }

                return this.titleCase(str)
            },
            getTitle: function (field) {
                if (typeof field.title === 'undefined') {
                    return field.name.replace('.', ' ')
                }

                return field.title
            },
            isSpecialField: function (fieldName) {
                return fieldName.slice(0, 2) === '__'
            },
            titleCase: function (str) {
                return str.replace(/\w+/g, function (txt) {
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
                })
            },
            camelCase: function (str, delimiter = '_') {
                let self = this
                return str.split(delimiter).map(function (item) {
                    return self.titleCase(item)
                }).join('')
            },
            notIn: function (str, arr) {
                return arr.indexOf(str) === -1
            },
            loadData: function (success = this.loadSuccess, failed = this.loadFailed) {
                this.fireEvent('loading')

                this.httpOptions['params'] = this.getAllQueryParams()
//                console.log('params:', this.httpOptions['params'])

                console.log('http options params', this.httpOptions['params'])

                Vue.http.get(this.apiUrl, this.httpOptions).then(
                        success,
                        failed
                )
            },
            loadSuccess: function (response) {
                console.log('data', response)
                console.log('before')
                this.fireEvent('load-success', response)
                console.log('after')

                let body = this.transform(response.body)

                this.tableData = this.getObjectValue(body, this.dataPath, null)

                // not sure why there is this bug but this is the only way to get the pagination data
//                this.tablePagination = this.getObjectValue(body, this.paginationPath, null)
                this.tablePagination = response.body.pagination
                console.log('this.tablePagination1',this.tablePagination)
//                console.log('this.tablePagination',this.tablePagination)

                if (this.tablePagination === null) {
                    this.warn('vuetable: pagination-path "' + this.paginationPath + '" not found. '
                            + 'It looks like the data returned from the sever does not have pagination information '
                            + 'or you may have set it incorrectly.'
                    )
                }

                console.log('loaded0')


                this.$nextTick(function () {
                    console.log('loaded1')
                    this.fireEvent('pagination-data', this.tablePagination)
                    console.log('loaded2')
                    this.fireEvent('loaded')
                    console.log('loaded3')
                })
            },
            loadFailed: function (response) {
                console.log('load error:')
                this.fireEvent('load-error', response)
                this.fireEvent('loaded')
            },
            transform: function (data) {
                let func = 'transform'

                if (this.parentFunctionExists(func)) {
                    return this.$parent[func].call(this.$parent, data)
                }

                return data
            },
            parentFunctionExists: function (func) {
                return (func !== '' && typeof this.$parent[func] === 'function')
            },
            fireEvent: function (eventName, args) {
//                console.log('Event:', eventName, args)
                this.$emit(this.eventPrefix + eventName, args)

                // Edit here >>>
                eventHub.$emit(this.eventPrefix + eventName, args)
                // <<<
            },
            warn: function (msg) {
                if (!this.silent) {
                    console.warn(msg)
                }
            },
            getAllQueryParams: function () {
                let params = {}
                params[this.queryParams.sort] = this.getSortParam()
                params[this.queryParams.page] = this.currentPage
                params[this.queryParams.perPage] = this.perPage

                for (let x in this.appendParams) {
                    params[x] = this.appendParams[x]
                }

//                console.log('getAllQueryParams params: ', params)
//                this.fireEvent('query-params-updated', params)

                return params
            },
            getSortParam: function () {
//                console.log('getting sort1')

                if (!this.sortOrder || this.sortOrder.field == '') {
                    return ''
                }

//                console.log('getting sort2')

                if (typeof this.$parent['getSortParam'] == 'function') {
                    console.log('getSortParam', this.$parent['getSortParam'].call(this.$parent, this.sortOrder))
                    return this.$parent['getSortParam'].call(this.$parent, this.sortOrder)
                }

                return this.getDefaultSortParam()
            },
            getDefaultSortParam: function () {
                let result = '';

                for (let i = 0; i < this.sortOrder.length; i++) {
                    let fieldName = (typeof this.sortOrder[i].sortField === 'undefined')
                            ? this.sortOrder[i].field
                            : this.sortOrder[i].sortField;

                    result += fieldName + '|' + this.sortOrder[i].direction + ((i + 1) < this.sortOrder.length ? ',' : '');
                }

                console.log('defaultSearchParams', result)
                return result;
            },
            extractName: function (string) {
                return string.split(':')[0].trim()
            },
            extractArgs: function (string) {
                return string.split(':')[1]
            },
            isSortable: function (field) {
                return !(typeof field.sortField === 'undefined')
            },
            isCurrentSortField: function (field) {
                return this.currentSortOrder(field) !== false;
            },
            currentSortOrder: function (field) {
                if (!this.isSortable(field)) {
                    return false
                }

                for (let i = 0; i < this.sortOrder.length; i++) {
                    if (this.sortOrder[i].field === field.name) {
                        return i;
                    }
                }

                return false;
            },
            orderBy: function (field, event) {
                if (!this.isSortable(field)) return

                let key = this.multiSortKey.toLowerCase() + 'Key'

                if (this.multiSort && event[key]) { //adding column to multisort
                    this.multiColumnSort(field)
                } else {
                    //no multisort, or resetting sort
                    this.singleColumnSort(field)
                }

                this.currentPage = 1    // reset page index
                this.loadData()
            },
            multiColumnSort: function (field) {
                let i = this.currentSortOrder(field);

                if (i === false) { //this field is not in the sort array yet
                    this.sortOrder.push({
                        field: field.name,
                        direction: 'asc'
                    });
                } else { //this field is in the sort array, now we change its state
                    if (this.sortOrder[i].direction === 'asc') {
                        // switch direction
                        this.sortOrder[i].direction = 'desc'
                    } else {
                        //remove sort condition
                        this.sortOrder.splice(i, 1);
                    }
                }

                console.log('this.sortOrder', this.sortOrder)

                // Ammendment
//                this.fireEvent('sort-order-updated', this.sortOrder)
            },
            singleColumnSort: function (field) {
                if (this.sortOrder.length === 0) {
                    this.sortOrder.push({
                        field: '',
                        direction: 'asc'
                    });
                }

                this.sortOrder.splice(1); //removes additional columns

                if (this.sortOrder[0].field === field.name) {
                    // change sort direction
                    this.sortOrder[0].direction = this.sortOrder[0].direction === 'asc' ? 'desc' : 'asc'
                } else {
                    // reset sort direction
                    this.sortOrder[0].direction = 'asc'
                }
                this.sortOrder[0].field = field.name
                this.sortOrder[0].sortField = field.sortField

                // add update here
                if(typeof this.sortOrder[0].sortField !== 'undefined') {
                    console.log('sort-order-updated this.sortOrder: ', this.sortOrder)
                    this.fireEvent('sort-order-updated', this.sortOrder)
                }

                console.log('this.sortOrder single', this.sortOrder)
            },
            sortIcon: function (field) {
                let cls = {}
                let i = this.currentSortOrder(field);

                if (i !== false) {
                    if (this.sortOrder[i].direction == 'asc') {
                        cls[this.css.ascendingIcon] = true
                    } else {
                        cls[this.css.descendingIcon] = true
                    }
                }

                return cls;
            },
            sortIconOpacity: function (field) {
                /*
                 * fields with stronger precedence have darker color
                 *
                 * if there are few fields, we go down by 0.3
                 * ex. 2 fields are selected: 1.0, 0.7
                 *
                 * if there are more we go down evenly on the given spectrum
                 * ex. 6 fields are selected: 1.0, 0.86, 0.72, 0.58, 0.44, 0.3
                 */
                let max = 1.0,
                        min = 0.3,
                        step = 0.3

                let count = this.sortOrder.length;
                let current = this.currentSortOrder(field)


                if (max - count * step < min) {
                    step = (max - min) / (count - 1)
                }

                let opacity = max - current * step

                return opacity
            },
            hasCallback: function (item) {
                return item.callback ? true : false
            },
            callCallback: function (field, item) {
                if (!this.hasCallback(field)) return

                let args = field.callback.split('|')
                let func = args.shift()

                if (typeof this.$parent[func] === 'function') {
                    let value = this.getObjectValue(item, field.name)

                    return (args.length > 0)
                            ? this.$parent[func].apply(this.$parent, [value].concat(args))
                            : this.$parent[func].call(this.$parent, value)
                }

                return null
            },
            getObjectValue: function (object, path, defaultValue) {
                defaultValue = (typeof defaultValue === 'undefined') ? null : defaultValue

                let obj = object
                if (path.trim() != '') {
                    let keys = path.split('.')
                    keys.forEach(function (key) {
                        if (obj !== null && typeof obj[key] !== 'undefined' && obj[key] !== null) {
                            obj = obj[key]
                        } else {
                            obj = defaultValue
                            return
                        }
                    })
                }
                return obj
            },
            toggleCheckbox: function (dataItem, fieldName, event) {
                let isChecked = event.target.checked
                let idColumn = this.extractArgs(fieldName)
                if (idColumn === undefined) {
                    this.warn('You did not provide reference id column with "__checkbox:<column_name>" field!')
                    return
                }

                let key = dataItem[idColumn]
                if (isChecked) {
                    this.selectId(key)
                } else {
                    this.unselectId(key)
                }
            },
            selectId: function (key) {
                console.log('key', key)
                if (!this.isSelectedRow(key)) {
                    this.selectedTo.push(key)
                    eventHub.$emit('vuetable:selected-to-updated', this.selectedTo)
                }
            },
            unselectId: function (key) {
                this.selectedTo = this.selectedTo.filter(function (item) {
                    return item !== key
                })
                eventHub.$emit('vuetable:selected-to-updated', this.selectedTo)
            },
            isSelectedRow: function (key) {
                return this.selectedTo.indexOf(key) >= 0
            },
            rowSelected: function (dataItem, fieldName) {
                let idColumn = this.extractArgs(fieldName)
                let key = dataItem[idColumn]

                return this.isSelectedRow(key);
            },
            toggleAllCheckboxes: function (fieldName, event) {
                let self = this
                let isChecked = event.target.checked
                let idColumn = this.extractArgs(fieldName)

                if (isChecked) {
                    this.tableData.forEach(function (dataItem) {
                        self.selectId(dataItem[idColumn])
                    })
                } else {
                    this.tableData.forEach(function (dataItem) {
                        self.unselectId(dataItem[idColumn])
                    })
                }
            },
            gotoPreviousPage: function () {
                if (this.currentPage > 1) {
                    this.currentPage--
                    this.loadData()
                }
            },
            gotoNextPage: function () {
                if (this.currentPage < this.tablePagination.last_page) {
                    this.currentPage++
                    this.loadData()
                }
            },
            gotoPage: function (page) {
                if (page != this.currentPage && (page > 0 && page <= this.tablePagination.last_page)) {
                    this.currentPage = page
                    this.loadData()
                }
            },
            isVisibleDetailRow: function (rowId) {
                return this.visibleDetailRows.indexOf(rowId) >= 0
            },
            showDetailRow: function (rowId) {
                if (!this.isVisibleDetailRow(rowId)) {
                    this.visibleDetailRows.push(rowId)
                }
            },
            hideDetailRow: function (rowId) {
                if (this.isVisibleDetailRow(rowId)) {
                    this.visibleDetailRows.splice(
                            this.visibleDetailRows.indexOf(rowId),
                            1
                    )
                }
            },
            toggleDetailRow: function (rowId) {
                if (this.isVisibleDetailRow(rowId)) {
                    this.hideDetailRow(rowId)
                } else {
                    this.showDetailRow(rowId)
                }
            },
            onRowClass: function (dataItem, index) {
                var func = this.rowClassCallback.trim()

                if (func !== '' && typeof this.$parent[func] === 'function') {
                    return this.$parent[func].call(this.$parent, dataItem, index)
                }
                return ''
            },
            onRowChanged: function (dataItem) {
                this.fireEvent('row-changed', dataItem)
                return true
            },
            onRowClicked: function (dataItem, event) {
                this.$emit(this.eventPrefix + 'row-clicked', dataItem, event)
                return true
            },
            onDetailRowClick: function (dataItem, event) {
                this.$emit(this.eventPrefix + 'detail-row-clicked', dataItem, event)
            },
            onCellClicked: function (dataItem, field, event) {
                this.$emit(this.eventPrefix + 'cell-clicked', dataItem, field, event)
            },
            onCellDoubleClicked: function (dataItem, field, event) {
                this.$emit(this.eventPrefix + 'cell-dblclicked', dataItem, field, event)
            },
            /*
             * API for externals
             */
            changePage: function (page) {

                console.log('Changing page:', page)

                if (page === 'prev') {
                    this.gotoPreviousPage()
                } else if (page === 'next') {
                    this.gotoNextPage()
                } else {
                    this.gotoPage(page)
                }
            },
            reload: function () {
                this.loadData()
            },
            refresh: function () {
                console.log('refresh - vt')
//                console.log('perPage3', this.perPage)
//                if(typeof this.perPage === String) {
//                    this.perPage = parseInt(this.perPage)
//                }
                this.currentPage = 1
                this.loadData()
            },
        }, // end: methods
        watch: {
            'multiSort': function (newVal, oldVal) {
                if (newVal === false && this.sortOrder.length > 1) {
                    this.sortOrder.splice(1);
                    this.loadData();
                }
            }
        },
    }
</script>

<style>
    .vuetable th.sortable:hover {
        color: #2185d0;
        cursor: pointer;
    }

    .vuetable-actions {
        width: 15%;
        padding: 12px 0px;
        text-align: center;
    }

    .vuetable-pagination {
        background: #f9fafb !important;
    }

    .vuetable-pagination-info {
        margin-top: auto;
        margin-bottom: auto;
    }
</style>
