<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WoDetail extends Model
{
    use SoftDeletes;
    protected $table = 'wodetail';
    protected $fillable = ['wonumber',
        'wo_id',
        'quantity',
        'description',
        'price'];

    public function production(){
        return $this->hasMany(\App\Models\Production::class);
    }
}