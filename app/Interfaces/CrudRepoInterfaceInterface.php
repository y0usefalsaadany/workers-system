<?php

namespace App\Interfaces;

interface CrudRepoInterfaceInterface
{
    public function store($data);
    public function show();
    public function update($id, $request);
    public function approvedOrders();
}
