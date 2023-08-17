<?php

namespace App\Exports;

use App\Models\Post;
use App\Models\Worker;
use Maatwebsite\Excel\Concerns\FromCollection;

class WorkerExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Post::where('worker_id', auth()->guard('worker')->id())->get();
    }
}
