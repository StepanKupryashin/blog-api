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

    public function likes()
    {
        return $this->hasMany(LikePost::class, 'post_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }


    public function getAttributeImage()
    {
        return request()->getSchemeAndHttpHost() . $this->getAttribute('image');
    }


    public function scopePosts()
    {
        $posts = $this->all();
        foreach ($posts as $post) {
            $post->author = $post->user;
            $post->comments;
            $post->count_like = $post->likes->count();
            $post->user_like =  auth()->guard('api')->user() ? LikePost::where('post_id', $post->id)
                ->where(
                    'author_id',
                    auth()->guard('api')->user()->id
                )
                ->get()->count() >= 1 : false;

            $post->image = request()->getSchemeAndHttpHost() . '/' . $post->image;
        }
        return $posts;
    }
    // магия ларавеля не хочет нормально работать (я про scope), поэтому это просто статик метод
    public static function search($text)
    {
        $posts = Post::where('text', 'like', '%' . $text . "%")
            ->orWhere('name', 'like', '%' . $text . "%")
            ->get();

        foreach ($posts as $post) {
            $post->author = $post->user;
            $post->image = request()->getSchemeAndHttpHost() . '/' . $post->image;
        }
        return $posts;
    }


}
