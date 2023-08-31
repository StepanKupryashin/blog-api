<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\LikePost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::posts();
        return $this->successResponse($posts);
    }

    public function show(string $id)
    {

        $posts = Post::posts()->where("id", (int) $id);
        return $this->successResponse(...$posts);
    }

    public function search(Request $request)
    {
        // мне лень использовать laaravel/scout пусть будет обычный like
        return $this->successResponse(
            Post::search($request->get('text'))
        );
    }

    public function commentPost(int $postId, Request $request)
    {
        return $this->successResponse(
            Comment::create([
                'author_id' => $request->user()->id,
                'post_id' => $postId,
                'text' => $request->get('text', "")
            ])
        );
    }

    public function likePost(int $postId, Request $request)
    {
        if (
            LikePost::where('post_id', $postId)
                ->where(
                    'author_id',
                    $request->user()->id
                )
                ->get()->count() >= 1
        ) {

            LikePost::where('author_id', $request->user()->id)
                ->where('post_id', $postId)->delete();
            return $this->successResponse([
                'message' => 'the current user like has been deleted'
            ]);

        }

        return $this->successResponse(
            LikePost::create([
                'author_id' => $request->user()->id,
                'post_id' => $postId
            ])
        );
    }

    public function getCommentsByPost(int $postId, Request $request)
    {
        return $this->successResponse(
            Comment::byPost($postId)
        );
    }

    public function createPost(Request $request)
    {
        return $this->successResponse(
            Post::create([
                'name' => $request->get('name'),
                'author' => $request->user()->id,
                'text' => $request->get('text'),
                'image' => 'images/post.jpg'
            ])
            );
    }

    public function userPosts(Request $request)
    {
        return $this->successResponse(
            Post::userPosts()
        );
    }
}
