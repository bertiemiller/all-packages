require('../bootstrap/admin_data_tables_bootstrap');

// import Platform from '../mixins/platform.vue';
import EditForm from '../components/edit.vue';

var vm1 = new Vue({

    el: '#app',

    // mixins: [Platform],

    components: {
        'edit-form': EditForm,
    },

});
