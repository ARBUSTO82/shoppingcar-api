<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\shoppingcar;
use App\Models\shoppingcaritem;

class ShoppingcarController extends Controller
{
   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->input('opcion')=='addItem'){
            $this->addItemProduct(
                $request->input('id'),
                $request->input('name'),
                $request->input('description'),
                $request->input('price')
            );
            return response()->json([
                'status'     => 201,
                'mensaje'    => 'Producto Agregado al Carrito'
            ]);
        }
        elseif($request->input('opcion')=='getCar'){
            $shoppingcar = shoppingcar::where(array('status'=> 0,'borrado'=>0))->get();
            if(count($shoppingcar)==0){
                return response()->json([
                    'status'     => 404,
                    'car'    => 'No se encontraron datos de Carrito'
                ]);
            }
            //return $shoppingcar;
            $items = shoppingcaritem::where(array('idshoppingcar'=> $shoppingcar[0]->id,'borrado'=>0))->get();
            $datosGenerales = array(
                'totalPrecio' => $shoppingcar[0]->totalprice,
                'totalItems' => $shoppingcar[0]->totalitems,
                'items'=>$items
            );
            return response()->json([
                'status'     => 201,
                'car'    => $datosGenerales
            ]);
        }
        elseif($request->input('opcion')=='deleteItem'){
            $shoppingcaritem = shoppingcaritem::find($request->input('id'));
            $shoppingcaritem->borrado = 1;
            $talPrecio = $shoppingcaritem->price;
            $shoppingcar = shoppingcar::find($shoppingcaritem->idshoppingcar);
            $shoppingcar->totalprice -= $talPrecio;
            $shoppingcar->totalitems -= 1;
            $shoppingcar->save();
            $shoppingcaritem->save();
            return response()->json([
                'status'     => 201,
                'mensaje'    => 'El Producto se ha sacado del carrito'
            ]);
        }
        elseif($request->input('opcion')=='deleteCar'){
            $shoppingcar = shoppingcar::find($request->input('id'));
            $shoppingcar->borrado = 1;
            $shoppingcar->save();
            return response()->json([
                'status'     => 201,
                'mensaje'    => 'El carrito se ha eliminado'
            ]);
        }
        elseif($request->input('opcion')=='concluirCar'){
            $shoppingcar = shoppingcar::find($request->input('id'));
            $shoppingcar->status = 1;
            $shoppingcar->save();
            return response()->json([
                'status'     => 201,
                'mensaje'    => 'El carrito se ha concluido'
            ]);
        }
        else{
            return response()->json([
                'status'     => 404,
                'mensaje'    => [
                    'id'     => 1,
                    'men'    => 'Opcion Invalida'
                ]
            ]); 
        }
        
    }

    private function addItemProduct($idproducto,$name,$description,$price){
        $shoppingcar = shoppingcar::firstOrCreate(
            ['status' => 0],
            ['totalprice' => 0, 'totalitems' => 0, 'status' => 0, 'borrado' => 0]
        );
        $idCar  = $shoppingcar->id;
        $producto = new shoppingcaritem();
        $producto->idshoppingcar = $idCar;
        $producto->idproducto = $idproducto;
        $producto->name = $name;
        $producto->description = $description;
        $producto->price = $price;
        $shoppingcar->totalprice += $price;
        $shoppingcar->totalitems += 1;
        $shoppingcar->save();
        $producto->save();
    }
}
