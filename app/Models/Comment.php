<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Orderable; // New trait Orderable has been created taking a function from here !!!


class Comment extends Model
{
    use SoftDeletes,Orderable; // Use soft delete Trait !!!

    protected $fillable = [
            'body',
            'user_id',
            'reply_id'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class,'reply_id','id')->orderBy('created_at','desc');
    }

    public function user()
    {
        return $this->belongsTo(User::Class);
    }
}
