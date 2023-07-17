<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\Posts\StoringPostRequest;
use App\Models\PostPhoto;
use App\Services\PostService\StoringPostService;
use Exception;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    function store(StoringPostRequest $request)
    {
        return (new StoringPostService())->store($request);
    }
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            "posts" => $posts
        ]);
    }

    public function approved()
    {
        $posts = Post::with('worker:id,name')->where('status', 'approved')->get();
        return response()->json([
            "posts" => $posts
        ]);
    }
}
