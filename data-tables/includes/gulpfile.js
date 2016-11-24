
const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir(mix => {

    // DataTables

    mix.webpack('admin/datatables/apps/index.js', './public/js/admin/datatables/apps');
    mix.webpack('admin/datatables/apps/create.js', './public/js/admin/datatables/apps');
    mix.webpack('admin/datatables/apps/edit.js', './public/js/admin/datatables/apps');

});