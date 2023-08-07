<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Worker;
use App\Models\WorkerReview;
use Illuminate\Http\Request;
use App\Http\Requests\Worker\UpdatingProfileRequest;
use App\Services\WorkerService\UpdatingProfileService;

class WorkerProfileController extends Controller
{
    public function userProfile()
    {
        $workerId = auth()->guard('worker')->id();
        $worker = Worker::with("posts.reviews")->find($workerId)->makeHidden('status', 'verified_at', 'verification_token');
        $reviews = WorkerReview::whereIn("post_id", $worker->posts()->pluck('id'));
        $rate = round($reviews->sum('rate') / $reviews->count(), 1);
        return response()->json([
            "data" => array_merge($worker->toArray(), ["rate" => $rate]),
        ]);
    }

    public function edit()
    {
        return response()->json([
            "worker" => Worker::find(auth()->guard('worker')->id())->makeHidden('status', 'verified_at', 'verification_token')
        ]);
    }
    public function update(UpdatingProfileRequest $request)
    {
        return (new UpdatingProfileService())->update($request);
    }
    public function delete()
    {
        Post::where('worker_id', auth()->guard('worker')->id())->delete();
        return response()->json([
            "message" => "deleted"
        ]);
    }
}
