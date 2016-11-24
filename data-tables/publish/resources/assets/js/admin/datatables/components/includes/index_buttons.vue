
<script>
    import DomainMixin from '../mixins/domain.vue';

    export default{
        template: [
            '<div>',
//             '<button class="ui green button" @click="onClick(\'select-items\', rowData)"><i class="zoom icon"></i></button>',
            '<button class="ui blue button" @click="onClick(\'edit-item\', rowData)"><i class="edit icon"></i></button>',
            '<button class="ui red button" @click="onClick(\'delete-item\', rowData)"><i class="delete icon"></i></button>',
            '</div>'
        ].join(''),
        props: {
            rowData: {
                type: Object,
                required: true
            }
        },
        mixins: [DomainMixin],
        methods: {

            created: function () {
                this.setHeadersAndStorage()
            },

            onClick: function (action, data) {
                console.log('actions: on-click', data.name)
                // sweetAlert(action, data.name)

                if (action == 'view-item') {
                    this.redirectToShow(data)
                }

                else if (action == 'edit-item') {
                    this.redirectToUrlWithId(data)
                }

                else if (action == 'delete-item') {
                    sweetAlert({
                                title: "Are you sure?",
                                text: "You will not be able to recover this imaginary file!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Yes, delete it!",
                                closeOnConfirm: false
                            },
                            this.deleteItem(data))
                }

                else if (action == 'select-items') {
                    console.log('select-items:');
                    console.log(data);
                    var parentRepo = document.querySelector('meta[name="_relation_parentRepo"]')['content'];
                    localStorage.setItem('_relation_parentRepo', parentRepo);
                    localStorage.setItem('_relation_child_url', document.querySelector('meta[name="_relation_url"]')['content']);
                    localStorage.setItem('_relation_return_url', document.querySelector('meta[name="_url"]')['content']);
                    localStorage.setItem('_relation_relationship', document.querySelector('meta[name="_relation_relationship"]')['content']);
                    localStorage.setItem('_relation_header_view', document.querySelector('meta[name="_relation_header_view"]')['content']);
                    localStorage.setItem('_relation_parent_id', data.id);
                    var url = document.querySelector('meta[name="_relation_url"]')['content']
                    window.location.href = url;
                }

            },

            // deleteRowItem(item){
            //     // eventHub.$emit('vuetable:delete-item', item)
            //     console.log('deleteRowItem', item)
            //     var index;
            //     this.$refs.vuetable.tableData.some(function (entry, i) {
            //         if (entry.id == item.id) {
            //             index = i;
            //             return true;
            //         }
            //     });
            //
            //     console.log('dataItemIndex:', this.$refs.vuetable.tableData[index]);
            //     this.$refs.vuetable.tableData.splice(index, 1)
            //
            // },


            deleteItem(item) {

                var url = this.apiDomain + '/api/data/:id';
                url = url.replace(':id', item.id);
                var request_options = {
                    _method: 'DELETE',
                };

                this.$http.post(url, request_options)
                        .then((response) => {

                            console.log('Success - deleting:');
                            console.log(response);
                            // this.deleteRowItem(item)
                            eventHub.$emit('vuetable:delete-item', item)
                            eventHub.$emit('flash-message-response', response)

                        }, (response) => {

                            // error callback
                            console.log('Error');
                            console.log(response);
                            eventHub.$emit('error-response', response)

                        });
            },
            redirectToUrlWithId(item) {
//                consoloe.log(item);
                var url = this.siteDomain + window.location.pathname;
                console.log(this.siteDomain);
                console.log(window.location.pathname);
                url = url + '/:id/edit';
                url = url.replace(':id', item.id);
                window.location.href = url;
            },
            redirectToShow(item){
                //                consoloe.log(item);
                var url = this.siteDomain + window.location.pathname;
                console.log(this.siteDomain);
                console.log(window.location.pathname);
                url = url + '/:id';
                url = url.replace(':id', item.id);
                window.location.href = url;
            },

            setHeadersAndStorage()
            {
//                localStorage.clear();

//                Vue.http.interceptors.push((request, next) => {
//
//                    // Api DataController
//                    request.headers.set('Site-Controller-Path', document.querySelector('meta[name="_controller_path"]')['content']);
//                    request.headers.set('Site-Repo-Path', document.querySelector('meta[name="_repo_path"]')['content']);
//                    request.headers.set('Site-Request-Path', document.querySelector('meta[name="_request_path"]')['content']);
//                    request.headers.set('Site-Route-Name', document.querySelector('meta[name="_route_name"]')['content']);
//
//                    next();
//                });


                var relation_child_url = localStorage.getItem('_relation_child_url');
                if(null !== relation_child_url && relation_child_url != document.querySelector('meta[name="_index_url"]')['content']) {

                    // need a loop function that deletes based on a key
                    // http://stackoverflow.com/questions/7667958/clear-localstorage
                    for (var i = 0; i < localStorage.length; i++){
                        if (localStorage.getItem(localStorage.key(i)).substring(0, 10) == "/_relation_/1") {
                            localStorage.removeItem(localStorage.key(i));
                        }
                    }

                    // localStorage.removeItem('_relation_return_url');
                    // localStorage.removeItem('_relation_parentRepo');
                    // localStorage.removeItem('_relation_relationship');
                    // localStorage.removeItem('_relation_parent_id');
                    // localStorage.removeItem('_relation_child_url');
                    // localStorage.removeItem('_relation_header_view');


                }

                if (null !== relation_child_url) {

                    Vue.http.interceptors.push((request, next) => {
                        request.headers.set('Relation-Parent-Repo', localStorage.getItem('_relation_parent_repo'));
                        request.headers.set('Relation-Return-Url', localStorage.getItem('_relation_return_url'));
                        request.headers.set('Relation-Relationship', localStorage.getItem('_relation_relationship'));
                        request.headers.set('Relation-Parent-Id', localStorage.getItem('_relation_parent_id'));
                        request.headers.set('Relation-Header-View', localStorage.getItem('_relation_header_view'));

                        next();
                    });

                }

//                console.log('localStorage:');
//                console.log(Object.keys(localStorage));
//                console.log(Object.values(localStorage));

            }
        }
    }
</script>
