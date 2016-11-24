<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Topicmine\Core\Models\Account\Domain;

class DomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Domain::create(array(
            'url'     => 'earlybird.loc',
            'name' => 'Early Bird',
            'user_id' => 1,
            'account_id' => 1,
        ));

        Domain::create(array(
            'url'     => 'laravel.loc',
            'name' => 'Laravel',
            'user_id' => 1,
            'account_id' => 1,
        ));

        Domain::create(array(
            'url'     => 'earlybirdgeneral.loc',
            'name' => 'Early Bird General',
            'user_id' => 2,
            'account_id' => 2,
        ));

        Domain::create(array(
            'url'     => 'earlybirdadmin.loc',
            'name' => 'Early Bird Admin',
            'user_id' => 2,
            'account_id' => 2,
        ));

    }
}
