<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $fillable = [
        'wonumber',
        'user_id',
        'to',
        'from',
        'movement',
        'code',
        'item',
        'quantity',
        'supplier'];

    public static function getRules($warehouse, $transaction) {
        $rules = [
            'to' => 'required',
            'movement' => 'required',
            'code' => 'required',
            'warehouse' => 'required',
            'item' => 'required',
            'quantity' => 'required',
			'user_id' => 'required',
        ];
        if($transaction == 'Entrada'){
            if($warehouse != 'Bodega'){
                array_push($rules, ['wonumber' => 'required']);
            }
        }
        
        if($transaction == 'Interno'){
            array_push($rules, ['from' => 'required']);
        }
        return $rules;
    }

    public function wodetail(){
        return $this->belongsTo(\App\Models\WoDetail::class);
    }
    public function wo(){
        return $this->belongsTo(\App\Models\Wo::class);
    }
    public function user(){
        return $this->belongsTo(\App\User::class);
    }
    public function from(){
        return $this->belongsTo(\App\Models\Location::class, 'from');
    }
    public function to(){
        return $this->belongsTo(\App\Models\Location::class, 'to');
    }
}
