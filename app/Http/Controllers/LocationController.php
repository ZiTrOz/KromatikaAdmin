<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Location::orderBy('location')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByWarehouse($warehouse)
    {
        return Location::where('warehouse', $warehouse)->orderBy('location')->get();
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
            'warehouse' => 'required',
			'location' => 'required',
        ])->validate();

        if (Location::where('warehouse',$data['warehouse'])->where('location', $data['location'])->exists()) {
            return response()->json(['error' => 'La ubicacion ' . $data['location'] . ' ya existe en el almacen ' . $data['warehouse'] ], 500);
         }

        $data['user_id'] = 1;
        DB::beginTransaction();
        try{
            Location::create($data);

            DB::commit();
        }
        catch(\PDOException $e){
            DB::rollback();
            return response()->json(['errors' => $e], 500);
        }

        $locations = Location::get();

        return response()->json($locations, 200);  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        Validator::make($data, [
            'warehouse' => 'required',
			'location' => 'required',
        ])->validate();

        if (Location::where('warehouse',$data['warehouse'])->where('location', $data['location'])->where('id', '<>', $data['id'])->exists()) {
            return response()->json(['error' => 'La ubicacion ' . $data['location'] . ' ya existe en el almacen ' . $data['warehouse'] ], 500);
         }

        $data['user_id'] = 1;
        DB::beginTransaction();
        try{
            $location = Location::find($id);
            $location->warehouse = $data['warehouse'];
            $location->location = $data['location'];
            $location->save();

            DB::commit();
        }
        catch(\PDOException $e){
            DB::rollback();
            return response()->json(['errors' => $e], 500);
        }

        $locations = Location::get();

        return response()->json($locations, 200);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
