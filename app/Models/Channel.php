<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable; // useing Searchable trait


class Channel extends Model
{
    use Searchable;
    
    protected $fillable = [
    	'name',
    	'slug',
    	'description',
    	'image_filename'
    ];


    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function getImage()
    {
        return config('app.url') . 'storage/default.jpg';

    }

}
