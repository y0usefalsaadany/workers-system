<?php

namespace App\Services\WorkerService;

use App\Models\Worker;
use Illuminate\Http\UploadedFile;

class UpdatingProfileService
{
    protected $model;
    function __construct()
    {
        $this->model = Worker::find(auth()->guard('worker')->id());
    }

    public function password($data)
    {
        if (request()->has('password')) {
            $data['password'] = bcrypt(request()->password);
            return $data;
        }
        $data['password'] = $this->model->password;
        return $data;
    }

    public function photo($data)
    {
        if (request()->has('photo')) {
            $data['photo'] = (request()->file('photo') instanceof UploadedFile) ?
                request()->file('photo')->store('workers') : $this->model->photo;
            return $data;
        }
        $data['photo'] = null;
        return $data;
    }

    public function update($request)
    {
        $data =  $request->all();
        $data = $this->password($data);
        $data = $this->photo($data);
        $this->model->update($data);
        return response()->json([
            "message" => "updated"
        ]);
    }
}
