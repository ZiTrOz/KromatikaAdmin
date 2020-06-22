<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Wo;
use App\Models\WoDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class WoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Wo::with('wodetail')->orderBy('delivery_date')->get();  
    }

    public function getByProcess($process) {        
        return WoDetail::getByProcess($process)->get(); 
    }

    public function filter($filter)
    {
        if($filter == "En proceso")
            return Wo::where('status', '<>', 'Entregada')->with('wodetail')->orderBy('delivery_date', 'asc')->get();        
        else
            return Wo::where('status', 'Entregada')->with('wodetail')->orderBy('delivery_date', 'asc')->get();   
    }

    public function search(Request $request, $term){
        $pos = Wo::where('wonumber', 'like', '%'.$term.'%')
            ->orWhere('folio', 'like', '%'.$term.'%')
            ->with('wodetail')->orderBy('wonumber')
            ->get();

        return $pos;
    }

    public function delivery(Request $request, $id)
    {
        $data = $request->all();
        $po = Wo::find($id);
        $po->status = 'Entregado';
        $date = Carbon::parse($data['delivery_date']);
        $po->delivery_date = $date;
        $po->update();
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
            'wonumber' => 'required|unique:wo',
			'folio' => 'required|unique:wo',
			'date' => 'required',
            'customer' => 'required',
            'phone' => 'required',
            'delivery' => 'required',
            'delivery_date' => 'required',
        ])->validate();

        // if ($validator->fails()) {
        //     return redirect('oc/crear')
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }
        DB::beginTransaction();
        try{
            $woDetail = $data['wodetail'];
            $data['status'] = "Ingresada";
            $data['delivery_date'] = Carbon::parse($data['delivery_date'])->format('y-m-d');
            // dd($data);
            $data['toPay'] = doubleval($data['toPay']);
            $data['advance'] = doubleval($data['advance']);
            $data['subtotal'] = doubleval($data['subtotal']);
            $data['iva'] = doubleval($data['iva']);
            $data['total'] = doubleval($data['total']);
            $wo = Wo::create($data);

            foreach($woDetail as $prod){
                WoDetail::create([
                    'quantity' => $prod['quantity'],
                    'description' => $prod['description'],
                    'price'=> $prod['price'],
                    'wo_id' => $wo->id,
                    'machine' => $prod['machine']
                ]);
            }
            DB::commit();
        
        } catch(\PDOException $e){
            DB::rollback();
            return response()->json(['error' => $e], 500);
        }
        return response()->json(['success' => 'OK'], 200);       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\po  $po
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Wo::where('id', $id)->with('wodetail')->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\po  $po
     * @return \Illuminate\Http\Response
     */
    public function edit(Wo $po)
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
    public function update(Request $request, Wo $po)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\po  $po
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wo $po)
    {
        //
    }
}
