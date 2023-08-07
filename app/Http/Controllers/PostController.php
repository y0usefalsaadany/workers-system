<?php

namespace App\Http\Controllers;

use App\Filters\PostFilter;
use Exception;
use App\Models\Post;
use App\Models\PostPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Posts\StoringPostRequest;
use App\Services\PostService\StoringPostService;

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

    public function approved(Request $request)
    {
        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters((new PostFilter)->filter())
            ->with('worker:id,name')
            ->where('status', 'approved')
            ->get(['id', 'content', 'price', 'worker_id']);
        return response()->json([
            "posts" => $posts
        ]);
    }
}
