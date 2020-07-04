<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\WoDetail;

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

    protected $maps = [
        'date' => 'Fecha',
        'customer' => 'Cliente',
        'delivery' => 'Entrega',
        'wonumber' => 'Orden de Trabajo',
    ];

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