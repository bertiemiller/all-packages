<script>

    import Domain from './domain.vue'

    export default{

        mixins: [Domain],

        methods: {

            setHeadersAndStorage()
            {
//                console.log('localStorage start:');
//                console.log(Object.keys(localStorage));
//                console.log(Object.values(localStorage));

                var _relation_childRoute = localStorage.getItem('_relation_childRoute');
                console.log('_relation_childRoute', _relation_childRoute)

//                var _index_url = document.querySelector('meta[name="_index_url"]')['content']
                var _index_route_name = document.querySelector('meta[name="_index_route_name"]')['content']

                if(null !== _relation_childRoute && _relation_childRoute != _index_route_name) {
                    console.log('removing local storage', _relation_childRoute, localStorage.length)

                    localStorage.removeItem('_relation_childRoute');
                    localStorage.removeItem('_relation_childRepo');
                    localStorage.removeItem('_relation_parentName');
                    localStorage.removeItem('_relation_parentClassName');
                    localStorage.removeItem('_relation_parentRepo');
                    localStorage.removeItem('_relation_parentId');
                    localStorage.removeItem('_relation_returnUrl');
                    localStorage.removeItem('_relation_returnPath');
                    localStorage.removeItem('_relation_relationship');
                    localStorage.removeItem('_relation_headerView');


                    // Do this last
                    console.log('localStorage:');
                    console.log(Object.keys(localStorage));
                    console.log(Object.values(localStorage));
                }

                var _relation_childRoute_again = localStorage.getItem('_relation_childRoute');

                if (null !== _relation_childRoute_again) {
                    console.log('relation_childRoute recognised: setting headers')

                    var relation = [];
                    relation['childRoute'] = localStorage.getItem('_relation_childRoute')
                    relation['childRepo'] = localStorage.getItem('_relation_childRepo')
                    relation['parentName'] = localStorage.getItem('_relation_parentName')
                    relation['parentClassName'] = localStorage.getItem('_relation_parentClassName')
                    relation['parentRepo'] = localStorage.getItem('_relation_parentRepo')
                    relation['parentId'] = localStorage.getItem('_relation_parentId')
                    relation['returnUrl'] = localStorage.getItem('_relation_returnUrl')
                    relation['returnPath'] = localStorage.getItem('_relation_returnPath')
                    relation['relationship'] = localStorage.getItem('_relation_relationship')
                    relation['headerView'] = localStorage.getItem('_relation_headerView')

                    console.log('setHeadersAndStorage relation params:', relation)


                    Vue.http.interceptors.push((request, next) => {
                        request.headers.set('Relation-Parent-Repo', relation['parentRepo']);
                        request.headers.set('Relation-Return-Url', relation['returnPath']);
                        request.headers.set('Relation-Relationship', relation['relationship']);
                        request.headers.set('Relation-Parent-Id', relation['parentId']);
                        next();
                    });

                    eventHub.$emit('vuetable:relation-updated', relation)
                } else {
                    console.log('relation_childRoute not recognised: ')
                }

//                console.log('localStorage:');
//                console.log(Object.keys(localStorage));
//                console.log(Object.values(localStorage));
            },



            redirectToChildRelation(item, relation)
            {
//                localStorage.clear();
                var parentId = item.id
                console.log('redirectToChildRelation', item, parentId, relation)

                var keys = Object.keys(item)

                if(! (keys.indexOf('name') > -1)) {
                    relation['parentName'] = item[keys[2]]
                }
                else {
                    relation['parentName'] = item['name']
                }

                localStorage.setItem('_relation_childRoute', relation['childRoute']);
                localStorage.setItem('_relation_childRepo', relation['childRepo']);
                localStorage.setItem('_relation_parentName', relation['parentName']);
                localStorage.setItem('_relation_parentClassName', relation['parentClassName']);
                localStorage.setItem('_relation_parentRepo', document.querySelector('meta[name="_repo_path"]')['content']);
                localStorage.setItem('_relation_parentId', parentId);
                localStorage.setItem('_relation_returnUrl', window.location.href);
                localStorage.setItem('_relation_returnPath', window.location.pathname);
                localStorage.setItem('_relation_relationship', relation['relationship']);
                localStorage.setItem('_relation_headerView', relation['headerView']);

                console.log('localStorage end after setting:');
                console.log(Object.keys(localStorage));
                console.log(Object.values(localStorage));

                var url = this.siteDomain + relation['childPath']
                window.location.href = url;
                return
            }
        },

        created: function () {
            this.setHeadersAndStorage()
        },

        beforeDestroy: function () {

        },
    }



</script>