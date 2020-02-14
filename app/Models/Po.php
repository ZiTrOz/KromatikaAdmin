<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Po extends Model
{
    use SoftDeletes;

    protected $table = 'po';
    protected $fillable = ['ponumber',
        'folio',
        'customer',
        'date',
        'phone',
        'delivery',
        'advance',
        'toPay',
        'subtotal',
        'iva',
        'total'];

    public function podetail(){
        return $this->hasMany(\App\Models\PoDetail::class);
    }
}