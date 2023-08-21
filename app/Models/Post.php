<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'author');
    }


    public function getAttributeImage()
    {
        return request()->getSchemeAndHttpHost() . $this->getAttribute('image');
    }


    public function scopePosts() {
        $posts = $this->all();
        foreach ($posts as $post) {
            $post->author = $post->user;
            $post->image = request()->getSchemeAndHttpHost() .'/'.  $post->image;
        }
        return $posts;
    }


}
