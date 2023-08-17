<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientOrderRequest;
use App\Interfaces\CrudRepoInterfaceInterface;
use App\Models\ClientOrder;
use Illuminate\Http\Request;

class ClientOrderController extends Controller
{

    protected $crudRepo;
    public function __construct(CrudRepoInterfaceInterface $crudRepo)
    {
        $this->crudRepo = $crudRepo;
    }
    public function addOrder(ClientOrderRequest $request)
    {
        return $this->crudRepo->store($request);
    }

    public function workerOrder()
    {
        return $this->crudRepo->show();
    }

    public function update($id, Request $request)
    {
        return $this->crudRepo->update($id, $request);
    }
    public function approvedOrders()
    {
        return $this->crudRepo->approvedOrders();
    }
}
