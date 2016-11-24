require('../bootstrap/admin_data_tables_bootstrap');

// import Errors from '../components/errors/errors.vue';
// import Message from '../components/messages/message.vue';
//
// Vue.component('errors', Errors);
// Vue.component('messages', Message);

// import Vuetable from 'vuetable-2/src/components/Vuetable.vue';
import Vuetable from '../components/vendor/vuetable/Vuetable.vue';
Vue.component('vuetable', Vuetable);

// import Vuetable from '../components/index/Vuetable.vue';
// import VuetablePagination from 'vuetable-2/src/components/VuetablePagination.vue';
// import VuetablePaginationDropdown  from 'vuetable-2/src/components/VuetablePaginationDropdown.vue';
// import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo.vue';

// Vue.component(Vuetable);
// Vue.component(VuetablePagination)
// Vue.component(VuetablePaginationDropdown)
// Vue.component(VuetablePaginationInfo)

// Vue.component('vuetable-pagination', VuetablePagination)
// Vue.component('vuetable-pagination-dropdown', VuetablePaginationDropdown)
// Vue.component('vuetable-pagination-info', VuetablePaginationInfo)

// import VuetableExtensions from '../components/index/vuetable_extensions.vue'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination.vue';
import VuetablePaginationDropdown  from 'vuetable-2/src/components/VuetablePaginationDropdown.vue';
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo.vue';
// import DomainMixin from '../mixins/domain.vue';
import CustomButtons from '../components/includes/index_buttons.vue';

Vue.component('vuetable-pagination', VuetablePagination)
Vue.component('vuetable-pagination-dropdown', VuetablePaginationDropdown)
Vue.component('vuetable-pagination-info', VuetablePaginationInfo)
Vue.component('custom-actions', CustomButtons)

//
// Vue.component('custom-actions', {
//     template: [
//         '<div>',
//         // '<button class="ui red button" @click="onClick(\'view-item\', rowData)"><i class="zoom icon"></i></button>',
//         '<button class="ui blue button" @click="onClick(\'edit-item\', rowData)"><i class="edit icon"></i></button>',
//         '<button class="ui red button" @click="onClick(\'delete-item\', rowData)"><i class="delete icon"></i></button>',
//         '</div>'
//     ].join(''),
//     props: {
//         rowData: {
//             type: Object,
//             required: true
//         }
//     },
//     mixins: [DomainMixin],
//     methods: {
//         onClick: function (action, data) {
//             console.log('actions: on-click', data.name)
//             // sweetAlert(action, data.name)
//
//             if (action == 'view-item') {
//                 this.redirectToShow(data)
//             }
//
//             else if (action == 'edit-item') {
//                 this.redirectToUrlWithId(data)
//             }
//
//             else if (action == 'delete-item') {
//                 sweetAlert({
//                         title: "Are you sure?",
//                         text: "You will not be able to recover this imaginary file!",
//                         type: "warning",
//                         showCancelButton: true,
//                         confirmButtonColor: "#DD6B55",
//                         confirmButtonText: "Yes, delete it!",
//                         closeOnConfirm: false
//                     },
//                     this.deleteItem(data))
//             }
//
//             else if (action == 'select-items') {
//                 console.log('select-items:');
//                 console.log(data);
//                 var parentRepo = document.querySelector('meta[name="_relation_parentRepo"]')['content'];
//                 localStorage.setItem('_relation_parentRepo', parentRepo);
//                 localStorage.setItem('_relation_child_url', document.querySelector('meta[name="_relation_url"]')['content']);
//                 localStorage.setItem('_relation_return_url', document.querySelector('meta[name="_url"]')['content']);
//                 localStorage.setItem('_relation_relationship', document.querySelector('meta[name="_relation_relationship"]')['content']);
//                 localStorage.setItem('_relation_header_view', document.querySelector('meta[name="_relation_header_view"]')['content']);
//                 localStorage.setItem('_relation_parent_id', data.id);
//                 var url = document.querySelector('meta[name="_relation_url"]')['content']
//                 window.location.href = url;
//             }
//
//         },
//
//         // deleteRowItem(item){
//         //     // eventHub.$emit('vuetable:delete-item', item)
//         //     console.log('deleteRowItem', item)
//         //     var index;
//         //     this.$refs.vuetable.tableData.some(function (entry, i) {
//         //         if (entry.id == item.id) {
//         //             index = i;
//         //             return true;
//         //         }
//         //     });
//         //
//         //     console.log('dataItemIndex:', this.$refs.vuetable.tableData[index]);
//         //     this.$refs.vuetable.tableData.splice(index, 1)
//         //
//         // },
//
//
//         deleteItem(item) {
//
//             var url = this.apiDomain() + '/api/data/:id';
//             url = url.replace(':id', item.id);
//             var request_options = {
//                 _method: 'DELETE',
//             };
//
//             this.$http.post(url, request_options)
//                 .then((response) => {
//
//                     console.log('Success - deleting:');
//                     console.log(response);
//                     // this.deleteRowItem(item)
//                     eventHub.$emit('vuetable:delete-item', item)
//                     eventHub.$emit('flash-message-response', response)
//
//                 }, (response) => {
//
//                     // error callback
//                     console.log('Error');
//                     console.log(response);
//                     eventHub.$emit('error-response', response)
//
//                 });
//         },
//         redirectToUrlWithId(item) {
// //                consoloe.log(item);
//             var url = this.siteDomain + window.location.pathname;
//             console.log(this.siteDomain);
//             console.log(window.location.pathname);
//             url = url + '/:id/edit';
//             url = url.replace(':id', item.id);
//             window.location.href = url;
//         },
//         redirectToShow(item){
//             //                consoloe.log(item);
//             var url = this.siteDomain + window.location.pathname;
//             console.log(this.siteDomain);
//             console.log(window.location.pathname);
//             url = url + '/:id';
//             url = url.replace(':id', item.id);
//             window.location.href = url;
//         }
//     }
//
// })


Vue.component('Collection', require('../components/index.vue'));

// import VuetableExtensions from '../components/index/vuetable_extentions.vue'
// import Typeahead from '../components/vendor/Typeahead.vue';
// Vue.component('typeahead', Typeahead);

// import Relation from '../components/mixins/relation.vue'


const app = new Vue({

    el: '#app',

    // components: {
    //     Vuetable,
    //     VuetablePagination,
    //     VuetablePaginationDropdown,
    //     VuetablePaginationInfo,
    // },

    // mixins: [Relation],

    // components: {
    //     'collection': Collection,
    // },

    // methods: {
    //     fireEvent: function(eventName, args) {
    //         console.log('event', eventName, args)
    //         this.$emit(this.eventPrefix + eventName, args)
    //         eventHub.$emit(this.eventPrefix + eventName, args)
    //     }
    // }

});


