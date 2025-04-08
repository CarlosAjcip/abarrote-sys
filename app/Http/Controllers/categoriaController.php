<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Caracteristica;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCategoriaRequest;

class categoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::with('caracteristica')->latest()->get();

        return view('categorias.index',  ['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoriaRequest $request)
    {
        try {
            DB::beginTransaction();
            $caracteristicas = Caracteristica::create($request->validated());
            $caracteristicas->categoria()->create([
                'caracteristica_id' => $caracteristicas->id
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return redirect()->route('categoria.index')->with('success', 'Categoria registrada');
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
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', ['categoria' => $categoria]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        Caracteristica::where('id', $categoria->caracteristica->id)->update($request->validated());

        return redirect()->route('categoria.index')->with('success', 'Categoria Editada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menssage = '';
        $categoria = Categoria::find($id);

        if ($categoria->caracteristica->estado == 1) {
            Caracteristica::where('id', $categoria->caracteristica->id)
                ->update(
                    [
                        'estado' => 0
                    ]
                );
                $menssage = 'Categoria Eliminda';
        } else {
            Caracteristica::where('id', $categoria->caracteristica->id)
                ->update(
                    [
                        'estado' => 1
                    ]
                );
                $menssage = 'Categoria Restaurada';
        }

        return redirect()->route('categoria.index')->with('success', $menssage);
    }
}
