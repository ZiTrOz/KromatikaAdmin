<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $table = 'supplier';
    protected $fillable = [
        'name',
        'user_id',
    ];

    public static function getRules(){
        $rules = [
            'name' => 'required|unique:supplier',
            'user_id' => 'required'
        ];

        return $rules;
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
