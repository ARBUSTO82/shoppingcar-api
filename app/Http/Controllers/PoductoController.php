<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;

class PoductoController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->input('opcion')=='create'){
            $this->createProduct(
                $request->input('name'),
                $request->input('description'),
                $request->input('price')
            );
            return response()->json([
                'status'     => 201,
                'mensaje'    => 'Producto creado'
            ]);
        }
        elseif($request->input('opcion')=='all'){
            $productos = Productos::where('borrado', 0)->orderBy('name')->get();
            return $productos;
        }
        elseif($request->input('opcion')=='show'){
            $productos = Productos::find($request->input('id'));
            return $productos;
        }
        elseif($request->input('opcion')=='edit'){
            $this->editProduct(
                $request->input('id'),
                $request->input('name'),
                $request->input('description'),
                $request->input('price')
            );
            return response()->json([
                'status'     => 201,
                'mensaje'    => 'Producto Editado'
            ]);
        }
        elseif($request->input('opcion')=='delete'){
            $productos = Productos::find($request->input('id'));
            $productos->borrado = 1;
            $productos->save();
            return response()->json([
                'status'     => 201,
                'mensaje'    => 'Producto Borrado'
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

    private function createProduct($name,$description,$price){
        $producto = new Productos();
        $producto->name = $name;
        $producto->description = $description;
        $producto->price = $price;
        $producto->save();
    }

    private function editProduct($id,$name,$description,$price){
        $producto = Productos::find($id);
        $producto->name = $name;
        $producto->description = $description;
        $producto->price = $price;
        $producto->save();
    }

}
