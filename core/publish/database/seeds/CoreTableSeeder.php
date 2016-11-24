<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment() === 'production') exit();

        Model::unguard();

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $this->call(AccountsTableSeeder::class);
        $this->call(CoreUsersTableSeeder::class);

        $this->call(RolesTableSeeder::class);
        $this->call(PermissionGroupsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(UserRolesAndPermissionsSeeder::class);

        $this->call(DomainsTableSeeder::class);
        $this->call(UserContactsTableSeeder::class);
        $this->call(UserDatabasesTableSeeder::class);

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        Model::reguard();
        
    }
}
