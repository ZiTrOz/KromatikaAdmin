<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'delivery';
    protected $fillable = ['ponumber',
        'wo_id',
        'wodetail_id',
        'user_id',
        'delivery_date',
        'notes'
    ];

    public function production(){
        return $this->hasMany(\App\Models\Production::class);
    }
}
