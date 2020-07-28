<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
    protected $table = 'item';
    protected $fillable = [
        'item',
        'description',
        'color',
        'supplier_id',
        'code',
        'user_id',
        'uom',
        'department',
        'cost',
    ];

    public static function getRules(){
        $rules = [
            'code' => 'required|unique:item',
            'item' => 'required|unique:item',
            'description' => 'required',
            'color' => 'required',
            'supplier_id' => 'required',
            'department' => 'required',
            'uom' => 'required',
            'cost' => 'required',
            'user_id' => 'required'
        ];

        return $rules;
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }

    public function supplier(){
        return $this->belongsTo(\App\Models\Supplier::class);
    }
}
