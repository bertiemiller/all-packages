
<script>
    import Domain from './domain.vue'

    export default{

//        mixinx: [Domain],

//        events: {
//
//        },

        methods:{
            setColumns: function(response) {

//                eventHub.$emit('vuetable:table-data-loaded', response.body.data)
//                console.log('load-success', response)

//              if(this.initialLoad === false) {
//                  this.initialLoad = true
//              } else {
////                  this.columnsSet = false
////                  this.normalizeFields()
////                  this.columnsSet = true
//                  return
//              }
//                this.showLoadingAnimation()

                console.log('setColumns')
//                console.log('data', response.body.data)

                this.setFieldsAndLoadTemplate(response)

                this.columnsSet = true
            },

            setFieldsAndLoadTemplate(response)
            {
                // if rows are null this will throw an error......
                // need to update

//                var data = response.body.data
                console.log('data first row eg', response.body.data[0])
                console.log('this.fields', this.fields)

                // reset fields
//                this.fields = []
//                if(Object.keys(this.relation).indexOf('parentClassName') > -1) {
//
//                }

                console.log('Object.keys(this.fields).length', Object.keys(this.fields).length)

                if(typeof response.body.data[0] !== 'undefined' && this.columnsSet !== true) {

//                }
//                if(! (Object.keys(this.fields).length > 0 && this.columnsSet !== true) ) {
                    console.log('setting fields')
                    this.setFields(response)
                    this.setSortOrder()
                    this.setSelectedIds(response)

//                    this.fireEvent('relation-updated', response.body.relation)
                    this.fireEvent('columns-set', this.fields)
                    this.columnsSet = true

                } else if(this.columnsSet !== true) {
                    console.log('not setting fields')
                    this.fireEvent('no-results')
                    this.columnsSet = true
                }

            },

            setFields(response){
                var keys = Object.keys(response.body.data[0])
                keys.forEach(function(field, i) {

                    var sortField = true;
                    var noTitle = false;
                    var prefix = '::notitle::';
                    if (field.substr(0,prefix.length) === prefix) {
                        var noTitle = true;
                        var sortField = false;
//                        field = field.substr(prefix.length)
                    }

//                    var relprefix = '__relation:';
//                    if (field.substr(0,relprefix.length) === relprefix) {
//                        var relation = []
//                        console.log('field setting', field)
////                        relation[field.relationship] = field
////                        this.relations.push(relation)
////                        console.log('relations', this.relations)
//                    }

                    this.fields[i] = {
                        'name': field,
//                        'sortField': field,
                        titleClass: 'center aligned',
                        dataClass: 'center aligned',
//                        callback: 'gender'
//                        callback: 'formatDate|D/MM/Y'
                    }

                    if (noTitle) {
                        this.fields[i].title = ''
                    }

                    if (sortField) {
                        this.fields[i].sortField = field
                    }

                    var callbackFuncName = field + 'Callback';
                    if (typeof callbackFuncName == 'function') {
                        this.fields[i].callback = callbackFuncName
                    }

                }, this)

                // add to front
                var checkbox = {
                    name: '__checkbox:id',
                    sortField: 'id',
                    title: 'id',
                }
                this.fields.unshift(checkbox);

                // add to end
                var buttons = {
                    name: '__component:custom-actions',
//                    sortField: 'custom-actions',
                    title: '',
                }
                this.fields.push(buttons);

                this.normalizeFields()
//                console.log('fields', this.fields);
            },

            setSortOrder()
            {
                // set sorter if name doesn't exist
                if(! (this.fields.indexOf('name') > -1)) {
                    this.sortOrder = [{
                        field: this.fields[2].name, // get third col (first = checkbox, second = id ->
                        sortField: this.fields[2].name, // get third col (first = checkbox, second = id ->
                        direction: 'asc'
                    }]
                }
                this.fireEvent('sort-order-updated', this.sortOrder)
            },

            setSelectedIds(response)
            {
                response.body.data.forEach(function (row, i) {
                    if(response.body.selectedIds.indexOf(row.id) >= 0) {
                        this.selectedTo.push(row.id)
                    }
                })
//                console.log('this.selectedTo:',this.selectedTo)
//                ventHub.$emit('vuetable:selected-to-updated', this.selectedTo)
                this.fireEvent('selected-to-updated', this.selectedTo)
            },

            deleteItem(item){

                console.log('deleteRowItem', item)
                var index;
                this.tableData.some(function (entry, i) {
                    if (entry.id == item.id) {
                        index = i;
                        return true;
                    }
                });

                console.log('dataItemIndex:', index, this.tableData[index]);
                this.tableData.splice(index, 1)

            },

//            changeMPage(page) {
//                console.log('page', page)
//                this.changePage(page)
//            },

            changePerPage(perPage) {
                console.log('perPage',perPage)
                this.perPage = perPage
                this.refresh()
            },

            loadError(response)
            {
                console.log('error recieving')
                eventHub.$emit('error-response', response)
            },

            changeAppendParams(appendParams)
            {
                this.appendParams = appendParams
            }


        },

        created: function () {
            eventHub.$on('vuetable:load-error', this.loadError)
            eventHub.$on('vuetable:load-success', this.setColumns)
            eventHub.$on('vuetable:refresh', this.refresh)
            eventHub.$on('vuetable:delete-item', this.deleteItem)
            eventHub.$on('vuetable:change-page', this.changePage)
            eventHub.$on('vuetable:change-per-page', this.changePerPage)
            eventHub.$on('vuetable:append-search-param-changed', this.changeAppendParams)
//            eventHub.$on('vuetable:query-params-updated', this.updateQueryParams)
        },

        beforeDestroy: function () {
            eventHub.$off('vuetable:load-error', this.loadError)
            eventHub.$off('vuetable:load-success', this.setColumns)
            eventHub.$off('vuetable:refresh', this.refresh)
            eventHub.$off('vuetable:delete-item', this.deleteItem)
            eventHub.$off('vuetable:change-page', this.changePage)
            eventHub.$off('vuetable:change-per-page', this.changePerPage)
            eventHub.$off('vuetable:append-search-param-changed', this.changeAppendParams)
//            eventHub.$off('vuetable:query-params-updated', this.updateQueryParams)
        }
    }
</script>


