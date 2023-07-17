<?php

namespace App\Repository;

use App\Models\ClientOrder;
use App\Interfaces\CrudRepoInterfaceInterface;

class ClientOrderRepo implements CrudRepoInterfaceInterface
{
    public function store($request)
    {
        $clinetId = auth()->guard('client')->id();
        if (ClientOrder::where('client_id', $clinetId)->where('post_id', $request->post_id)->exists()) {
            return response()->json([
                "message" => "duplicate order request"
            ], 406);
        }
        $data = $request->all();
        $data['client_id'] = $clinetId;
        $order = ClientOrder::create($data);
        return response()->json([
            "message" => "success"
        ]);
    }

    public function show()
    {
        $orders = ClientOrder::with('post', 'client')->whereStatus('pending')->whereHas('post', function ($query) {
            $query->where('worker_id', auth()->guard('worker')->id());
        })->get();
        return response()->json([
            "orders" => $orders
        ]);
    }
}
