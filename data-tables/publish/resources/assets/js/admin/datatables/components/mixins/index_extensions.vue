<style>
    .ui.vertical.stripe h3 {
        /*font-size: 2em;*/
        font-size: 1.5em;
    }
    .secondary.pointing.menu .toc.item {
        display: none;
    }
    .vuetable {
        margin-top: 1em !important;
    }
    /*.vuetable-wrapper.ui.basic.segment .vuetable table{*/
        /*border:0;*/
    /*}*/
    .vuetable-wrapper.ui.basic.segment {
        padding: 0em;
    }
    .vuetable button.ui.button {
        /*padding: .5em .5em;*/
        padding: .4em .4em;
        font-weight: 400;
    }
    .vuetable button.ui.button i.icon {
        margin: 0;
    }
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
    [v-cloak] {
        display: none;
    }
    .highlight {
        background-color: yellow;
    }
    .vuetable-detail-row {
        height: 200px;
    }
    .detail-row {
        margin-left: 40px;
    }
    .expand-transition {
        transition: all .5s ease;
    }
    .expand-enter, .expand-leave {
        height: 0;
        opacity: 0;
    }
    tr.odd {
        background-color: #e6f5ff;
    }
    body {
        overflow-y: scroll;
    }
</style>

<script>


    export default{

        methods: {
            showSettingsModal () {
                $('#settingsModal').modal({
                    detachable: false,
                    onVisible: function() {
                        $('.ui.checkbox').checkbox()
                    }
                }).modal('show')
            },
            showLoader: function() {
                this.loading = 'loading'
            },
            hideLoader: function() {
                this.loading = ''
            },
            getFieldTitle: function(field) {
                if (field.title !== '') return field.title

                if (field.name.slice(0, 2) === '__') {
                    return field.name.indexOf(':') >= 0
                            ? field.name.split(':')[1]
                            : fiel.name.replace('__', '')
                }
            },
            allCap (value) {
                return value.toUpperCase()
            },
            formatDate (value, fmt) {
                if (value === null) return ''
                fmt = (typeof(fmt) === 'undefined') ? 'D MMM YYYY' : fmt
                return moment(value, 'YYYY-MM-DD').format(fmt)
            },
            gender (value) {
                return value === 'M'
                        ? '<span class="ui teal label"><i class="male icon"></i>Male</span>'
                        : '<span class="ui pink label"><i class="female icon"></i>Female</span>'
            },
            showDetailRow: function(value) {
                let icon = this.$refs.vuetable.isVisibleDetailRow(value) ? 'down' : 'right'
                return [
                    '<a class="show-detail-row">',
                    '<i class="chevron circle ' + icon + ' icon"></i>',
                    '</a>'
                ].join('')
            },
            preg_quote: function( str ) {
                // http://kevin.vanzonneveld.net
                // +   original by: booeyOH
                // +   improved by: Ates Goral (http://magnetiq.com)
                // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                // +   bugfixed by: Onno Marsman
                // *     example 1: preg_quote("$40");
                // *     returns 1: '\$40'
                // *     example 2: preg_quote("*RRRING* Hello?");
                // *     returns 2: '\*RRRING\* Hello\?'
                // *     example 3: preg_quote("\\.+*?[^]$(){}=!<>|:");
                // *     returns 3: '\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:'

                return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
            },
            highlight: function(needle, haystack) {

                console.log('needle, haystack', needle, haystack)

                if( typeof haystack !== 'string') {
                    haystack = haystack.toString()
                }

                return haystack.replace(
                        new RegExp('(' + this.preg_quote(needle) + ')', 'ig'),
                        '<span class="highlight">$1</span>'
                )
                
            },
            rowClassCB: function(data, index) {
                return (index % 2) === 0 ? 'odd' : 'even'
            },
            onCellClicked (data, field, event) {
                console.log('cellClicked', field.name)
                if (field.name !== '__actions') {
                    this.$refs.vuetable.toggleDetailRow(data.id)
                }
            },
            onCellDoubleClicked (data, field, event) {
                console.log('cellDoubleClicked:', field.name)
            },
            onLoadSuccess (response) {
                this.tableData = response.body.data
                // set pagination data to pagination-info component
                this.$refs.paginationInfo.setPaginationData(response.body.pagination)

                let data = response.body.data
                if (this.searchFor !== '') {
                    for (let n in data) {

//                        var field = this.sortOrder[0].sortField

                        data[n][this.searchField] =
                                this.highlight(this.searchFor, data[n][this.searchField])

//                        data[n][this.sortOrder[0].sortField] =
//                                this.highlight(this.searchFor, data[n][this.sortOrder[0].sortField])
//                        data[n].name = this.highlight(this.searchFor, data[n].email)
//                        data[n].email = this.highlight(this.searchFor, data[n].email)

                    }
                }
            },
            onLoadError (response) {
                if (response.status == 400) {
                    sweetAlert('Something\'s Wrong!', response.data.message, 'error')
                } else {
                    sweetAlert('Oops', E_SERVER_ERROR, 'error')
                }
            },
            onPaginationData (tablePagination) {
                this.$refs.paginationInfo.setPaginationData(tablePagination)
                this.$refs.pagination.setPaginationData(tablePagination)
            },
//            onChangePage (page) {
//                console.log('changePage', page)
//                console.log('this.$refs',this.$refs)
//                console.log('this.$refs.vuetable',this.$refs.vuetable)
//                this.$refs.vuetable.changePage(page)
//            },
            registerEvents () {
                let self = this
                this.$on('vuetable:action', (action, data) => {
                    self.onActions(action, data)
                })
                this.$on('vuetable:cell-clicked', (data, field, event) => {
                    self.onCellClicked(data, field, event)
                })
                this.$on('vuetable:cell-dblclicked', (data, field, event) => {
                    self.onCellDoubleClicked(data, field, event)
                })
                this.$on('vuetable:load-success', (response) => {
                    self.onLoadSuccess(response)
                })
                this.$on('vuetable:load-error', (response) => {
                    self.onLoadError(response)
                })
            },
            filterable(field) {
                var columnPrefix = ['id', '__', '::']

                if (columnPrefix.indexOf(field.name.substr(0, 2)) > -1) {
                    return false
                }

                return true
            }

        }


    }
</script>
