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
        $validator = Validator::make($data, [
            'wonumber' => 'required|unique:wo',
			'date' => 'required',
            'customer' => 'required',
            'phone' => 'required',
            'delivery' => 'required',
            'delivery_date' => 'required',
        ])->setAttributeNames(
            [
                'wonumber' => 'Orden de Trabajo',
                'date' => 'Fecha',
                'customer' => 'Cliente',
                'phone' => 'Teléfono',
                'delivery' => 'Entrega',
                'delivery_date' => 'Fecha de Entrega',
            ], 
        );

        $validator->validate();
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

            $folio = Wo::select(DB::raw('IFNULL(MAX(id),0) as id'))->first();
            $data['folio'] = 'K-' . sprintf('%07d', $folio->id + 1);
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

            return $wo;
        
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
        $data = $request->all();
        $validator = Validator::make($data, [
			'date' => 'required',
            'customer' => 'required',
            'phone' => 'required',
            'delivery' => 'required',
            'delivery_date' => 'required',
        ])->setAttributeNames(
            [
                'wonumber' => 'Orden de Trabajo',
                'date' => 'Fecha',
                'customer' => 'Cliente',
                'phone' => 'Teléfono',
                'delivery' => 'Entrega',
                'delivery_date' => 'Fecha de Entrega',
            ], 
        );

        $validator->validate();

        $woNumber = Wo::where('wonumber', $data['wonumber'])->where('id', '<>', $data['id'])->first();

        if($woNumber){
            return response()->json(['error' => 'Numero de orden de trabaja ya esta en uso'], 500);
        }

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

            $wo = Wo::find($data['id']);


            $wo->delivery_date = $data['delivery_date'];
            $wo->toPay = $data['toPay'];
            $wo->advance = $data['advance'];
            $wo->subtotal = $data['subtotal'];
            $wo->iva = $data['iva'];
            $wo->total = $data['total'];

            $wo->save();
            

            foreach($woDetail as $prod){
                $item = WoDetail::find($prod['id']);
                if($item){
                    $item->quantity = $prod['quantity'];
                    $item->description = $prod['description'];
                    $item->price = $prod['price'];
                    $item->machine = $prod['machine'];
                    $item->save();
                }
                else{
                    WoDetail::create([
                        'quantity' => $prod['quantity'],
                        'description' => $prod['description'],
                        'price'=> $prod['price'],
                        'wo_id' => $wo->id,
                        'machine' => $prod['machine']
                    ]);
                }
                
            }
            DB::commit();

            return Wo::find($data['id']);;
        
        } catch(\PDOException $e){
            DB::rollback();
            return response()->json(['error' => $e], 500);
        }
        return response()->json(['success' => 'OK'], 200);   
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
