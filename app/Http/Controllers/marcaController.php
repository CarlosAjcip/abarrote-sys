<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Caracteristica;
use App\Models\Marca;

class marcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $marcas = Marca::with('caracteristica')->latest()->get();
        return view('marcas.index',['marcas' => $marcas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marcas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMarcaRequest $request)
    {
        try {
            //code...
            DB::beginTransaction();
                $caracteristicas = Caracteristica::create($request->validated());
                $caracteristicas->marca()->create([
                    'caracteristica_id' => $caracteristicas->id
                ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->route('marca.index')->with('success','Marca registrada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        return view('marcas.edit', ['marca' => $marca]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMarcaRequest $request, Marca $marca)
    {
        Caracteristica::where('id',$marca->caracteristica->id)->update($request->validated());
        return redirect()->route('marca.index')->with('success','Marca Editada');
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
        $marca = Marca::find($id);

        if ($marca->caracteristica->estado  == 1) {
            # code...
            Caracteristica::where('id',$marca->caracteristica->id)
            ->update([
                'estado' => 0
            ]);
            $message = 'Marca Eliminada';
        }else {
            # code...
            Caracteristica::where('id',$marca->caracteristica->id)
            ->update([
                'estado' => 1
            ]);
            $message = 'Marca Restaurada';
        }

        return    redirect()->route('marca.index')->with('success', $message);
    }                    
}                             
