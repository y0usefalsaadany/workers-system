<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Client;
use App\Models\WorkerCash;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function pay($serviceId)
    {
        try {
            DB::beginTransaction();
            $post = Post::find($serviceId);
            $paylink = Client::find(auth()->guard('client')->id())->charge($post->price, $post->content);
            $workerCash = WorkerCash::create([
                "post_id" => $post->id,
                "client_id" => auth()->guard('client')->id(),
                "total" => $post->price,
            ]);
            DB::commit();
            return response()->json([
                "payLink" => $paylink
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                $e->getMessage()
            ]);
        }
    }
}
