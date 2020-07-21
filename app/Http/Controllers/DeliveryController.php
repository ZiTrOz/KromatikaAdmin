<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\WoDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function saveFirma($id,Request $request)
    {

        // $data = $request;

        // $validator = Validator::make($data, [
        //     'wo_id' => 'required',
        //     'wodetail_id' => 'required'
        // ])->setAttributeNames(
        //     [
        //         'wo_id' => 'Orden de Trabajo',
        //         'wodetail_id' => 'Producto',
        //     ], 
        // );

        // $validator->validate();
        DB::beginTransaction();
        try {
            $woDetail = WoDetail::find($id);
            $woDetail->status = 'Entregado';
    
            Delivery::create([
                'wo_id' => $woDetail->wo_id,
                'wodetail_id' => $id,
                'delivery_date'=> Carbon::now(),
                'user_id' => 1,
                'notes' => $request['notes']
            ]);
            $woDetail->save();
            $path = $request->firma->store('public/firmas/');
            $file = new File();
    
            $file->filetable_id = $id;
            $file->filetable_type = 'App\Models\Delivery';
            $file->type = 'Firma';
    
            $file->url = str_replace('public', 'storage', $path);
    
            $file->save();
            DB::commit();
        
        } catch(\PDOException $e){
            DB::rollback();
            return response()->json(['error' => $e], 500);
        }
        return response()->json(['success' => 'OK'], 200);    
       
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
        dd($request);
        //$delivey = Delivey::create($request);
        //php$var= "file1";
        $path = $request->firma->store('public/firmas/');
        $file = new File();

        $file->filetable_id = 1;
        $file->filetable_type = 'App\Models\Delivery';
        $file->type = 'Firma';

        $file->url = str_replace('public', 'storage', $path);

        $file->save();

        // Delivey::create({
            
        // });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delivey  $delivey
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delivey  $delivey
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivey  $delivey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivery $delivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        //
    }
}
