<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Po;
use App\Models\PoDetail;
use Illuminate\Http\Request;
use Validator;

class PoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Po::with('podetail')->get();        
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
        Validator::make($data, [
            'ponumber' => 'required|unique:po',
			'folio' => 'required|unique:po',
			'date' => 'required',
            'customer' => 'required',
            'phone' => 'required',
            'delivery' => 'required',
        ])->validate();

        // if ($validator->fails()) {
        //     return redirect('oc/crear')
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }

        $po = DB::transaction(function () use ($data) {
            $poDetail = $data['podetail'];

            $po = Po::create($data);

            foreach($poDetail as $prod){
                PoDetail::create([
                    'quantity' => $prod['quantity'],
                    'description' => $prod['description'],
                    'price'=> $prod['price'],
                    'po_id' => $po->id
                ]);
            }
            DB::commit();

        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\po  $po
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Po::where('id', $id)->with('podetail')->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\po  $po
     * @return \Illuminate\Http\Response
     */
    public function edit(Po $po)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\po  $po
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Po $po)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\po  $po
     * @return \Illuminate\Http\Response
     */
    public function destroy(Po $po)
    {
        //
    }
}
