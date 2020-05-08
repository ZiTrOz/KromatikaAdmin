<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    //use SoftDeletes;
    protected $table = 'production';
    protected $fillable = [
        'wodetail_id',
        'wo_id',
        'user_id',
        'notes',
        'time',
        'process',
        'date'];

    public function wodetail(){
        return $this->belongsTo(\App\Models\WoDetail::class);
    }
    public function wo(){
        return $this->belongsTo(\App\Models\Wo::class);
    }
    public function user(){
        return $this->belongsTo(\App\User::class);
    }
};
