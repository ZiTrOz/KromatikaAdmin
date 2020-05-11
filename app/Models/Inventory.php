<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $fillable = [
        'user_id',
        'location_id',
        'code',
        'item',
        'quantity',
        'warehouse'];

    public static function getRules() {
        $rules = [
            'location_id' => 'required',
            'code' => 'required',
            'warehouse' => 'required',
            'item' => 'required',
            'quantity' => 'required',
            'user_id' => 'required',
        ];
        return $rules;
    }

    public function location(){
        return $this->belongsTo(\App\Models\Location::class);
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }

    public static function getInventory(){
        return Inventory::with('user', 'location')->get();
     }

}
