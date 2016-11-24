<?php

namespace Topicmine\UrlScrape\Models;

use Illuminate\Database\Eloquent\Model;

class UrlScrape extends Model {

    protected $table = 'url_scrapes';

    public $fillable = [
        'name', 'user_id', 'account_id',
    ];

    public $updateFields = [
        'name'
    ];

    public function urls()
    {
        return $this->belongsToMany(Url::class,
            'url_scrape_urls', 'url_scrape_id', 'url_id');
    }

    public $relationships = [
        'urls' => [
            'childRepo' => Url::class,
            'relationship' => 'urls',
            'childRoute' => 'topicmine.url_scrape.url.index',
            'table' => 'url_scrape_urls',
            'headerView'   => 'url-scrape/headers/url_scrape_header.vue',
        ]
    ];

}