<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Wo;
use App\Models\WoDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
//use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $p = Production::with('wodetail')->with('wo')->with('user')->get();
        return $p;
    }

    public function getDetail($id)
    {
        $p = Production::where('wodetail_id', $id)->with('wodetail')->with('wo')->with('user')->get();
        return $p;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data['production'], [
            'wodetail_id' => 'required|',
			'wo_id' => 'required',
			'user_id' => 'required',
            'process' => 'required',
            'date' => 'required',
            'time' => 'required'
        ])->validate();

        DB::beginTransaction();
        try{
            $production =Production::create($data['production']);

            $wo = Wo::find($data['production']['wo_id']);

            $wo->status = $data['production']['process'];

            $wodetail = WoDetail::find($production->wodetail_id);

            if($production->process == 'Diseño') {
                $wodetail->status = $wo->status = 'Producción';
            }
                
            if($production->process == 'Producción'){
                $wodetail->status = $wo->status = 'Acavados';
            }

            $wodetail->save();
            $wo->save();

            DB::commit();
        }
        catch(\PDOException $e){
            DB::rollback();
            return response()->json(['error' => $e], 500);
        }

        return response()->json(['success' => 'OK'], 200);       
        

        // if ($validator->fails()) {
        //     return redirect('oc/crear')
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }
    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        Validator::make($data['production'], [
            'wodetail_id' => 'required|',
			'wo_id' => 'required',
			'user_id' => 'required'
        ])->validate();

        DB::beginTransaction();
        try{           

            $wo = Wo::find($data['production']['wo_id']);

            $wo->status = $data['production']['process'];

            $wodetail = WoDetail::find($data['production']['wodetail_id']);
            
            $wodetail->status = $wo->status = 'Trabajando';

            $wodetail->save();
            $wo->save();

            DB::commit();
        }
        catch(\PDOException $e){
            DB::rollback();
            return response()->json(['error' => $e], 500);
        }

        return response()->json(['success' => 'OK'], 200);       
        

        // if ($validator->fails()) {
        //     return redirect('oc/crear')
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function show($po_id)
    {
        $p = Production::where('wo_id', $po_id)->with('wodetail')->with('wo')->with('user')->get();
        return $p;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function edit(Production $production)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Production $production)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Production $production)
    {
        //
    }
}
