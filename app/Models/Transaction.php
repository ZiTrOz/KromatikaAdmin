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
                $rules = $rules + array('wonumber' => 'required');
            }
        }
        
        if($transaction == 'Interno'){
            $rules = $rules + array('from' => 'required');
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

    public static function getTransactions(){
       return Transaction::with('user', 'to', 'from')->get();
    }
}
