<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Topicmine\UrlScrape\Models\Url;
use Topicmine\UrlScrape\Models\UrlScrape;

class UrlTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scrape = new UrlScrape;
        $scrape->create([
            'name' => 'Scrape Laravel Sites',
            'user_id' => 1,
            'account_id' => 1,
        ]);

        $scrape->find(1)->urls()->create([
            'url' => 'https://laravel.com',
            'user_id' => 1,
            'account_id' => 1,
        ]);
        $scrape->find(1)->urls()->create([
            'url' => 'https://laravel-news.com',
            'user_id' => 1,
            'account_id' => 1,
        ]);
        $scrape->find(1)->urls()->create([
            'url' => 'https://github.com/LaravelCollective',
            'user_id' => 1,
            'account_id' => 1,
        ]);
        $scrape->find(1)->urls()->create([
            'url' => 'https://laracasts.com',
            'user_id' => 1,
            'account_id' => 1,
        ]);
    }
}
