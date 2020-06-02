<?php

namespace App\Models\Polls;

use Illuminate\Database\Eloquent\Model;

class PollQuestionsOption extends Model
{
    protected $fillable = [
        'option',
        'poll_question_id'
    ];
}
