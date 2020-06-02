<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = [
        'name',
        'description',
        'slug'
    ];

    public function events(){
        return $this->hasMany(PollEvent::class);
    }
    public function questions(){
        return $this->hasMany(PollQuestion::class);
    }
}
