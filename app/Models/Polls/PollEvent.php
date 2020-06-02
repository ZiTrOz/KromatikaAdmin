<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Model;

class PollEvent extends Model
{
    protected $fillable = [
        'poll_id',
        'wonumber',
    ];
}
