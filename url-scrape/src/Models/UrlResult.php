<?php

namespace Topicmine\UrlScrape\Models;

use Illuminate\Database\Eloquent\Model;

class UrlResult extends Model
{
    protected $table = 'url_results';

    public $fillable = [
        'url_id',
        // and all the results columns....
    ];

    public function url()
    {
        return $this->belongsTo(Url::class, 'url_id');
    }

}
