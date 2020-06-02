<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Model;

class PollQuestion extends Model
{
    protected $fillable = [
        'question',
        'type'
    ];

    public function options(){
        return $this->hasMany(PollQuestionsOption::class);
    }
}
