<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Polls\Poll;
use App\Models\Polls\PollAnswer;
use App\Models\Polls\PollEvent;
use Illuminate\Support\Facades\DB;

class PollsController extends Controller
{
    public function index(){
        return Poll::whereStatus(1)
            ->with('questions.options')
            ->get();
    }

    public function show($poll_slug){
    
        $poll = Poll::whereSlug($poll_slug)
            ->with('questions.options')
            ->first();
            
        return $poll;
    }

    public function storeEvent(Request $request){

        DB::beginTransaction();
        try{
            $pollEvent = PollEvent::create($request->all());

            foreach($request->answers as $answer){
                $newAnswer = new PollAnswer();
                $newAnswer->poll_question_id = $answer['question_id'];
                if(is_array($answer['answer'])){
                    $tmp = implode(',', $answer['answer']);
                    $newAnswer->answer = $tmp;
                }else{
                    $newAnswer->answer = $answer['answer'];
                }
                $newAnswer->poll_event_id = $pollEvent->id;
                $newAnswer->save();
            }
            DB::commit();
            return $pollEvent;
        
        } catch(\PDOException $e){
            DB::rollback();
            return response()->json(['error' => $e], 500);
        }
        return response()->json(['success' => 'OK'], 200);      

        
    }
}
