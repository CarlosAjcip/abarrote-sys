<?php

namespace App\Http\Controllers;

use App\Models\proveedor;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProveedoresRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Requests\UpdateProveedoresRequest;
use App\Models\Persona;
use App\Models\Proveedore;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedor = Proveedore::with('persona.documento')->get();
        
        return view('proveedores.index',compact('proveedor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documentos = Documento::all();
        return view('proveedores.create', compact('documentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProveedoresRequest $request)
    {
        try {
            //code...
            DB::beginTransaction();
            $proveedor = Persona::create($request->validated());
            $proveedor->proveedore()->create([
                'proveedor_id' => $proveedor->id
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }

        return redirect()->route('proveedores.index')->with('success','Proveedor creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedore $proveedores)
    {
        $proveedores->load('persona.documento');
        $documentos = Documento::all();
        return view('proveedores.edit', compact('proveedores','documentos'));
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProveedoresRequest $request, Proveedore $proveedores)
    {
        try {
            //code...
            DB::beginTransaction();
                Persona::where('id', $proveedores->persona->id)
                ->update($request->validated());
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }

        return redirect()->route('proveedores.index')->with('success','Proveedor editado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = '';
        $persona = Persona::find($id);

        if ($persona->estado == 1) {
            # code...
            Persona::where('id',$persona->id)
            ->update([
                'estado' => 0
            ]);

            $message = 'Proveedor Eliminado';
        } else {
            # code...
            Persona::where('id',$persona->id)
            ->update([
                'estado' => 1
            ]);

            $message = 'Proveedor Restaurado';
        }
        
        return redirect()->route('proveedores.index')->with('success', $message);
    }
}
