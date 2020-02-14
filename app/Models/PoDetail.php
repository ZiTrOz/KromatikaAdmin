<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PoDetail extends Model
{
    use SoftDeletes;
    protected $table = 'podetail';
    protected $fillable = ['ponumber',
        'po_id',
        'quantity',
        'description',
        'price'];
}