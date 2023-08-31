<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function author()
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }


    public static function byPost(int $postId)
    {
        $comments = Comment::where('post_id', $postId)->get();

        foreach ($comments as $comment) {
            $comment->author;
            $comment->current_user = auth()->guard('api')->user()
                ?
                $comment->author_id
                ==
                auth()->guard('api')->user()->id
                : false;
        }
        return $comments;
    }

}
