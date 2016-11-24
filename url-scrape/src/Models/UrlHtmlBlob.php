<?php

namespace Topicmine\UrlScrape\Models;

use Illuminate\Database\Eloquent\Model;
use Topicmine\UrlScrape\Models\Url;

class UrlHtmlBlob extends Model
{
    protected $table = 'url_html_blobs';

    public $fillable = [
        'url_id', 'html_blob', 'user_id', 'account_id',
    ];

    public function url()
    {
        return $this->belongsTo(Url::class, 'url_id');
    }
}
