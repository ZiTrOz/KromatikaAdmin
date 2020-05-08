<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wo extends Model
{
    use SoftDeletes;

    protected $table = 'wo';
    protected $fillable = ['wonumber',
        'folio',
        'customer',
        'date',
        'phone',
        'delivery',
        'advance',
        'toPay',
        'subtotal',
        'iva',
        'total',
        'status',
        'delivery_date',
        'machine',];

    public function production(){
        return $this->hasMany(\App\Models\Production::class);
    }

    public function wodetail(){
        return $this->hasMany(\App\Models\WoDetail::class);
    }

    public function firma(){
        return $this->morphMany(File::class, 'filetable');
    }
}