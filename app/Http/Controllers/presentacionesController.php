<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePresentacionesRequest;
use App\Http\Requests\UpdatePresentacionesRequest;
use App\Models\Caracteristica;
use App\Models\Presentacion;
use App\Models\Presentacione;

class presentacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presentaciones = Presentacion::with('caracteristica')->latest()->get();
        return view('presentaciones.index',['presentacione' => $presentaciones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('presentaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePresentacionesRequest $request)
    {
        try {
            //code...
            DB::beginTransaction();
                $caracteristicas = Caracteristica::create($request->validated());
                $caracteristicas->presentacione()->create(
                    [
                        'caracteristica_id' => $caracteristicas->id
                    ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->route('presentaciones.index')->with('success', 'Presentacion Registridada');
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
    public function edit(Presentacion $presentaciones)
    {
        return view('presentaciones.edit',['presentaciones' => $presentaciones]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePresentacionesRequest $request, Presentacion $presentaciones)
    {
        //
        Caracteristica::where('id', $presentaciones->caracteristica->id)->update($request->validated());
        return redirect()->route('presentaciones.index')->with('success','Presentacion Editada');
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
        $presentaciones = Presentacion::find($id);

        if ($presentaciones->caracteristica->estado == 1) {
            # code...
            Caracteristica::where('id',$presentaciones->caracteristica->id)
            ->update([
                'estado' => 0
            ]);

            $message = 'Presentacion Eliminada';
        } else {
            # code...
            Caracteristica::where('id',$presentaciones->caracteristica->id)
            ->update([
                'estado' => 1
            ]);

            $message = 'Presentacion Restaurada';
        }
        
        return redirect()->route('presentaciones.index')->with('success', $message);
    }
}
