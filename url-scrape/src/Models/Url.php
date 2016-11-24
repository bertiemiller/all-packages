<?php

namespace Topicmine\UrlScrape\Models;

use Illuminate\Database\Eloquent\Model;
use Topicmine\UrlScrape\Models\UrlHtmlBlob;
use Topicmine\UrlScrape\Models\UrlResult;

class Url extends Model
{

    protected $table = 'urls';

    public $fillable = [
        'url', 'user_id', 'account_id',
    ];

    public $updateFields = [
        'url'
    ];

    public function html_blobs()
    {
        return $this->hasMany(UrlHtmlBlob::class, 'url_id');
    }

    public function latest_html_blobs()
    {
        return $this->hasMany(UrlHtmlBlob::class, 'url_id')->latest();
    }

    public function url_results()
    {
        return $this->hasMany(UrlResult::class, 'url_id');
    }

    public function latest_url_results()
    {
        return $this->hasMany(UrlResult::class, 'url_id')->latest();
    }

    public function url_scrapes()
    {
        return $this->belongsToMany(UrlScrape::class,
            'url_scrape_urls', 'url_scrape_id', 'url_id');
    }
}
