<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $appends =['file_url'];

    protected function getFileUrlAttribute(){
        return  is_null($this->image_name) ? asset('uploads/posts-images/default.png'):asset('uploads/posts-images/'.$this->image_name);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }


    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }
}
