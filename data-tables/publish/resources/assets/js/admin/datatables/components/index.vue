<template>

    <div class="panel-body collection">
        <div class="box">
            <div class="box-body">
                <header-view v-if="showRelationHeader"></header-view>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-inline form-group">
                            <select v-model="searchField" class="form-control">
                                <option v-if="! isSpecialField(field.name)" v-for="field in columns"
                                        v-bind:value="field.sortField">
                                    {{ field.name }}
                                </option>
                            </select>
                            <input v-model="searchFor" class="form-control" @keyup.enter="setFilter"
                                   placeholder="Search...">
                            <div class="btn-group">
                                <a @click="setFilter">
                                    <button class="btn btn-primary">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-inline form-group">
                            <!--<label>Search:</label>-->
                            <!--<select v-model="sortOrder[0].sortField" class="form-control">-->
                            <!--@keyup.enter="setSearchField"-->
                            <!--@keyup.enter="setSortField"-->
                            <div class="btn-group">
                                <a @click="resetFilter">
                                    <button type="button" class="btn btn-default">
                                        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                                    </button>
                                </a>
                            </div>
                            <div class="btn-group">
                                <a @click="deleteChecked">
                                    <button type="button" class="btn btn-default btnDeleteIds">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </button>
                                </a>
                            </div>
                            <div class="btn-group">
                                <a @click="redirectToCreate"
                                   title="Create new --- model name --- s">
                                    <button type="button" class="btn btn-default btn-default">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dropdown form-inline pull-right">
                            <!--<label>Pagination:</label>-->
                            <!--<select class="form-control" v-model="paginationComponent">-->
                            <!--<option value="vuetable-pagination">vuetable-pagination</option>-->
                            <!--<option value="vuetable-pagination-dropdown">vuetable-pagination-dropdown</option>-->
                            <!--</select>-->
                            <label>Per Page:</label>
                            <select class="form-control" v-model.number="perPage">
                                <option :value.number=3>3</option>
                                <option :value.number=10>10</option>
                                <option :value.number=15>15</option>
                                <option :value.number=20>20</option>
                                <option :value.number=25>25</option>
                            </select>
                            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-cog"></i>
                            </button>
                            <ul class="dropdown-menu" v-if="columnsSet">
                                <li v-for="field in columns" v-if="filterable(field)">
                            <span class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="field.visible">
                                    {{ field.title == ''
                                        ? field.name.replace('__', '')
                                        : field.title }} <!-- need to capitlise -->
                                </label>
                            </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div :class="[{'vuetable-wrapper ui basic segment': true}, loading]">
                    <vuetable
                            api-url="http://api.master.loc/api/data"
                            :fields="columns"
                            :per-page="perPage"
                            data-path="data"
                            pagination-path="pagination"
                            :pagination-info-template="paginationInfoTemplate"
                            pagination-info-no-data-template="The requested query return no result"
                            table-class="table table-bordered table-striped table-hover no-top-border"
                            ascending-icon="glyphicon glyphicon-chevron-up"
                            descending-icon="glyphicon glyphicon-chevron-down"
                            :sort-order="sortOrder"
                            :query-params="{ sort: 'orderBy', page: 'page', perPage: 'per_page'}"
                            :multi-sort="multiSort"
                            :append-params="moreParams"
                            row-class-callback="rowClassCB"
                            loading-class="loading"
                            @vuetable:pagination-data="onPaginationData"
                            @vuetable:load-success="onLoadSuccess"
                            @vuetable:loading="showLoader"
                            @vuetable:loaded="hideLoader"
                            @vuetable:cell-clicked="onCellClicked"
                    ></vuetable>

                    <div class="vuetable-pagination ui bottom attached segment grid">
                        <vuetable-pagination-info ref="paginationInfo"
                                                  :pagination-info-template="paginationInfoTemplate"
                        ></vuetable-pagination-info>
                        <component :is="paginationComponent" ref="pagination"
                                   @vuetable-pagination:change-page="onChangePage"
                        ></component>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

    import IndexExtensions from './mixins/index_extensions.vue'
    import DomainMixin from './mixins/domain.vue';
    //    import DefaultHeaderView from './headers/default.vue';

    // empty header component
    Vue.component('headerView', {})

    export default{

        mounted() {
            console.log('Component ready.')
        },

//        components: {
//            'headerView': DefaultHeaderView,
//        },

        mixins: [IndexExtensions, DomainMixin],
//        mixins: [VuetableExtensions],

        data(){
            return {
                // Are fields and columns different? Check
                columns: [],
                fields: [],
//                itemActions: [
//                    {name: 'view-item', label: '', icon: 'zoom icon', class: 'ui teal button'},
//                    {name: 'edit-item', label: '', icon: 'edit icon', class: 'ui orange button'},
//                    {name: 'delete-item', label: '', icon: 'delete icon', class: 'ui red button'}
//                ],
                tableData: null,
                columnsSet: false,
                sortOrder: [{
                    field: 'name',
                    direction: 'asc'
//                    sortField
                }],
                multiSort: true,
                perPage: 10,
                moreParams: {},
                paginationComponent: 'vuetable-pagination',
                paginationInfoTemplate: 'Showing record: {from} to {to} from {total} item(s)',

//                loading: true,
                loading: '',

                // header
                searchFor: '',
                selectedTo: [],
                relation: {},
                showRelationHeader: false,
                unchecked: [],
                sortField: null,
                searchField: null
//                tableDataResults: null
            }
        },

        computed: {
            modelHeading: function () {

                console.log('heading', this.relation)

                if (Object.keys(this.relation).indexOf('parentClassName') > -1) {
                    return window.Laravel.model_plural_heading +
                            ' for ' + this.relation['parentClassName'] + ': ' + this.relation['parentName']
                }

                return window.Laravel.model_plural_heading;
            },

            apiUrl()
            {
                var url = this.apiDomain + '/api/data';
                return url;
            },

            getUnchecked () {
                this.unchecked = [];
                this.listIds.forEach(function (id) {
                    if (!(this.selectedTo.indexOf(id) > -1)) {
                        this.unchecked.push(id);
                    }
                }, this);
                return this.unchecked;
            },

            listIds () {
                var listIds = [];
                this.tableData.forEach(function (item) {
                    listIds.push(item.id);
                }, listIds);

                return listIds;
            }
        },

        methods: {


            isSpecialField: function (fieldName) {
                return fieldName.slice(0, 2) === '__'
            },

            onChangePage (page) {
                console.log('changePage--', page)
//                console.log('this.$refs',this.$refs)
//                console.log('this.$refs.vuetable',this.$refs.vuetable)
                eventHub.$emit('vuetable:change-page', page)
//                this.$refs.vuetable.changePage(page)
            },

            setColumns(columns) {
                console.log('columns-index components', columns)
                this.columns = columns
                this.searchField = this.columns[2].sortField
                console.log('this.searchField estColumns', this.searchField)
//                        this.sortOrder[0].field = sortOrder[0].field
                this.columnsSet = true
            },

            noResultsFound()
            {
                this.loading = ''
                this.columnsSet = true
            },

            deleteChecked() {

                var url = this.apiUrl + '/update-selected';
                var params = {
                    _method: 'PUT',
                    action: 'delete',
                    selectedIds: this.selectedTo,
                    uncheckedSelectedIds: this.getUnchecked,
                };

                console.log('params:');
                console.log(params);

                var deleteList = [];

                this.$http.post(url, params)
                        .then((response) => {

                            this.tableData.forEach(function (item) {

                                for (var i = 0; i < this.selectedTo.length; i++) {
                                    if (item.id == this.selectedTo[i]) {
                                        deleteList.push(item)
                                        break

                                    } else {
//                                        console.log('inot:', i)
                                    }
                                }
                            }, this);

                            for (var j = 0; j < deleteList.length; j++) {
                                eventHub.$emit('vuetable:delete-item', deleteList[j])
                            }

                            eventHub.$emit('flash-message-response', response);

                        }, (response) => {

                            console.log('Error');
                            console.log(response);
                            eventHub.$emit('error-response', response);

                        });
            },

            redirectToCreate() {
                var url = this.siteDomain + window.location.pathname + '/create';
                window.location.href = url;
            },

            setFilter: function () {
                console.log('this.sortOrder', this.sortOrder)
                console.log('this.searchFor', this.searchFor)
                this.moreParams = {
                    'search': this.searchFor,
//                    'searchFields': this.sortOrder[0].sortField + ':like'
                    'searchFields': this.searchField + ':like'
                }

//                this.moreParams = {
//                    'search': this.searchFor,
//                    'searchFields': this.sortOrder[0].field+':like'
//                }
//                this.$nextTick(function() {
//                    this.$refs.vuetable.refresh()
//                })


//                eventHub.$emit('vuetable:update-search-field', this.searchField)
                eventHub.$emit('vuetable:append-search-param-changed', this.moreParams)
                eventHub.$emit('vuetable:refresh')
            },
            resetFilter: function () {
                this.searchFor = ''
                this.setFilter()
//                eventHub.$emit('vuetable:refresh')
            },

            redirectToChild(path)
            {
                alert(path)

            },

//            setTableData(data){
//                this.tableData = data
//            },

            updateSelectedTo(selectedTo)
            {
                this.selectedTo = selectedTo
            },

            setRelationHeader(data)
            {
                console.log('setRelationHeader:', data)
                this.relation = data;
//                console.log('this.relation', this.relation)

                console.log('Object.keys(this.relation).indexOf(headerView)', Object.keys(this.relation).indexOf('headerView'))
                console.log('typeof this.relation.headerView', typeof this.relation.headerView)

                if (Object.keys(this.relation).indexOf('headerView') > -1 && this.relation.headerView != 'undefined') {

//                if (this.relation.headerView) {

                    console.log('going to load relation header')
//                    var path = './headers/' + this.relation.headerView;
//                    var file = new File(path);
//                    var result = file.open ('r');

//                    if(file) {
//                        var HeaderView = require(path);
                    var HeaderView = require('../../' + this.relation.headerView);
                    Vue.component('header-view', HeaderView)
                    this.showRelationHeader = true
//                    }

                }
            },

//            updateQueryParams(params)
//            {
//                console.log('params index', params)
//                this.sortOrder[0].field = params.orderBy.split("|")[0]
//                this.sortOrder[0].sortField = this.sortOrder[0].field
//                console.log('sortOrder index', this.sortOrder)
//            },

//            setSearchField(searchField)
//            {
//
//            },

            updateSortOrder(sortOrder){
                console.log('sortOrder index', sortOrder)
                this.sortOrder[0].field = sortOrder[0].field
                this.sortOrder[0].sortField = sortOrder[0].sortField
                console.log('sortOrder index', this.sortOrder)

//                this.moreParams = {
//                    'search': this.searchFor,
//                    'searchFields': this.sortOrder[0].sortField + ':like'
//                }
//                eventHub.$emit('vuetable:append-search-param-changed', this.moreParams)
            },

//            setSortField(field)
//            {
//                console.log('setSortField', field)
//                this.sortOrder[0].field = field
//                this.sortOrder[0].sortField = field
//
//                this.updateSortOrder(this.sortOrder)
//
//            }


//            updateQueryParams(params)
//            {
//                console.log('this.sortOrder index', this.sortOrder)
//                console.log('params index', params)
//
////                var fieldParams = this.sortOrder.orderBy.split("|");
////                [{
////                    field: 'name',
////                    direction: 'asc'
//////                    sortField
////                }]
//
//                this.sortOrder = [{
//                    field: params.orderBy.split("|")[0],
//                    direction: 'asc'
//                }]
//                console.log('this.sortOrder index end', this.sortOrder)
//
////                console.log('sortOrder index', sortOrder)
////                this.sortOrder = sortOrder
//            }
        },

//        events: {},

        watch: {
            'perPage': function (val, oldVal) {
                eventHub.$emit('vuetable:change-per-page', val)
//                this.$nextTick(function() {
//                    eventHub.$emit('vuetable:change-per-page' val)
////                    this.$refs.vuetable.refresh()
//                })
            },
            'paginationComponent' (val, oldVal) {
                this.$nextTick(function () {
                    this.$refs.pagination.setPaginationData(this.$refs.vuetable.tablePagination)
                })
            }
        },

        created: function () {
            this.registerEvents()
            eventHub.$on('vuetable:relation-updated', this.setRelationHeader)
            eventHub.$on('vuetable:columns-set', this.setColumns)
            eventHub.$on('vuetable:selected-to-updated', this.updateSelectedTo)
//            eventHub.$on('vuetable:load-error', this.loadError)
//            eventHub.$on('vuetable:query-params-updated', this.updateQueryParams)
            eventHub.$on('vuetable:sort-order-updated', this.updateSortOrder)
            eventHub.$on('vuetable:no-results', this.noResultsFound)

        },

        beforeDestroy: function () {
            eventHub.$off('vuetable:relation-updated', this.setRelationHeader)
            eventHub.$off('vuetable:columns-set', this.setColumns)
            eventHub.$off('vuetable:selected-to-updated', this.updateSelectedTo)
            eventHub.$off('vuetable:sort-order-updated', this.updateSortOrder)
//            eventHub.$off('vuetable:load-error', this.loadError)
//            eventHub.$off('vuetable:query-params-updated', this.updateQueryParams)
            eventHub.$off('vuetable:no-results', this.noResultsFound)
        },
    }
</script>

