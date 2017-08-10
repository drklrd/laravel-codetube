<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Video extends Model
{
    use SoftDeletes; // since this is a Trait, we need to use it.

    protected $fillable = [
    	'title',
        'description',
    	'uid',
    	'video_filename',
        'video_id',
        'processed',
        'visibility',
        'allow_votes',
        'allow_comments',
        'processed_percentage'
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function getRouteKeyName()
    {
        return 'uid';
    }


    // get latest video first
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at','desc');
    }

    public function isProcessed()
    {
        return $this->processed;
    }

    public function processedPercentage()
    {
        return $this->processed_percentage;
    }

    public function getThumbnail()
    {

        return config('app.url') . 'storage/default.jpg';

        // for S3 config do as below :

        // if(!$this->isProcessed){
        //     return config('codetube.buckets.videos') . '/default.png';
        // }
        //
        // return config('codetube.buckets.videos') . '/' .$this->video_id .'_1.png';

    }
}
