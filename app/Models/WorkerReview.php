<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerReview extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'post_id', 'comment', 'rate'];
    public function client()
    {
        return $this->belongsTo(client::class);
    }
}
