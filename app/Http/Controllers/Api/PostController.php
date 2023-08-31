<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

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
}
