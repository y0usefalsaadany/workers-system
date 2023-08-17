<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerCash extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'post_id', 'total'];
    public function client()
    {
        return $this->belongsTo(client::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
