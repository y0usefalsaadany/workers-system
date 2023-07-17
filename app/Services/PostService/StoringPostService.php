<?php

namespace App\Services\PostService;

use Exception;
use App\Models\Post;
use App\Models\Admin;
use App\Models\PostPhoto;
use App\Notifications\AdminPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class StoringPostService
{
    protected $model;
    function __construct()
    {
        $this->model = new Post();
    }
    public function adminPercent($price)
    {
        $discount = $price * 0.05;
        $priceAfterDiscount = $price - $discount;
        return $priceAfterDiscount;
    }
    function storePost($data)
    {
        $data = $data->except('photos');
        $data['price'] = $this->adminPercent($data['price']);
        $data['worker_id'] = auth()->guard('worker')->id();
        $post = Post::create($data);
        return $post;
    }

    function storePostPhotos($request, $postId)
    {
        foreach ($request->file('photos') as $photo) {
            $postPhotos = new PostPhoto();
            $postPhotos->post_id = $postId;
            $postPhotos->photo = $photo->store('posts');
            $postPhotos->save();
        }
    }

    function sendAdminNotification($post)
    {
        $admins = Admin::get();

        Notification::send($admins, new AdminPost(auth()->guard('worker')->user(), $post));
    }

    function store($request)
    {
        try {
            DB::beginTransaction();
            $post = $this->storePost($request);
            if ($request->hasFile('photos')) {
                $postPhotos = $this->storePostPhotos($request, $post->id);
            }
            $this->sendAdminNotification($post);
            DB::commit();
            return response()->json([
                "message" => "post has been created successfuly ,your price after discount is {$post->price}"
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
