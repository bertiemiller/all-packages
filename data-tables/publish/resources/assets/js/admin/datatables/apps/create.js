require('../bootstrap/admin_data_tables_bootstrap');

// import Platform from '../mixins/platform.vue';
import CreateForm from '../components/create.vue';
// import Relation from '../components/mixins/relation.vue'

var vm1 = new Vue({

    el: '#app',

    // mixins: [Relation],

    components: {
        'create-form': CreateForm,
    },

});
