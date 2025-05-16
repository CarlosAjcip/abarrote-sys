<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Presentacion;
use Illuminate\Http\Request;
use App\Models\Presentacione;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SotreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Support\Facades\Storage;

class productoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::with(['categorias.caracteristica','marca.caracteristica','presentacion.caracteristica'])->get();
  
        return view('producto.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //otra forma de hacer una consulta siempre en el paradigma eloquent
        // $marcas = Marca::whereHas('caracteristica', function ($query) {
        //     $query->where('estado', 1);
        // })->get();

        // dd($marcas);
        
        // $categorias = Categoria::whereHas('caracteristica', function ($query) {
        //     $query->where('estado', 1);
        // })->get();

        //y esta es otro forma
         $marcas = Marca::join('caracteristicas as c', 'marcas.caracteristica_id', '=', 'c.id')
            ->select('marcas.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)
            ->get();

        $presentaciones = Presentacion::join('caracteristicas as c', 'presentaciones.caracteristica_id', '=', 'c.id')
            ->select('presentaciones.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)
            ->get();

        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id', '=', 'c.id')
            ->select('categorias.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)
            ->get();

        return view('producto.create', compact('marcas','presentaciones','categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SotreProductoRequest $request)
    {
        try {
            //code...
            DB::beginTransaction();

                $producto = new Producto();

                if ($request->hasFile('img_path')) {
                    # code...
                    $name = $producto->handleUploadImage($request->file('img_path'));
                }else{
                    $name = null;
                }
                
                $producto->fill([
                    'codigo' => $request->codigo,
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'fecha_vencimiento' => $request->fecha_vencimiento,
                    'img_path' => $name,
                    'marca_id' => $request->marca_id,
                   'presentacion_id' => $request->presentacion_id

                ]);
                

                $producto->save();

                //tabla categoria producto
                $categorias = $request->get('categorias');
                $producto->categorias()->attach($categorias);

                
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            DB::rollBack();
        }

        return redirect()->route('producto.index')->with('success','Producto Registrado');
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
    public function edit(Producto $producto)
    {
        $marcas = Marca::join('caracteristicas as c', 'marcas.caracteristica_id', '=', 'c.id')
        ->select('marcas.id as id', 'c.nombre as nombre')
        ->where('c.estado',1)
        ->get();

      

        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id', '=', 'c.id')
        ->select('categorias.id as id', 'c.nombre as nombre')
        ->where('c.estado',1)
        ->get();

        $producto = Presentacion::join('caracteristicas as c', 'producto.caracteristica_id', '=', 'c.id')
        ->select('producto.id as id', 'c.nombre as nombre')
        ->where('c.estado',1)
        ->get();
       return view('producto.edit', compact('producto','marcas','categorias','producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        try {
            //code...
            DB::beginTransaction();


                if ($request->hasFile('img_path')) {
                    # code...
                    $name = $producto->handleUploadImage($request->file('img_path'));

                    if (Storage::disk('public')->exists('productos/' . $producto->img_path)) {
                        # code...
                        Storage::disk('public')->delete('productos/' . $producto->img_path);
                    }

                }else{
                    $name = $producto->img_path;
                }
                
                $producto->fill([
                    'codigo' => $request->codigo,
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'fecha_vencimiento' => $request->fecha_vencimiento,
                    'img_path' => $name,
                    'marca_id' => $request->marca_id,
                   'presentacion_id' => $request->presentacion_id

                ]);
                

                $producto->save();

                //tabla categoria producto
                $categorias = $request->get('categorias');
                $producto->categorias()->sync($categorias);

                
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            DB::rollBack();
        }

        return redirect()->route('producto.index')->with('success','Producto editado');
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
        $producto = Producto::find($id);

        if ($producto->estado == 1) {
            # code...
            Producto::where('id',$producto->id)
            ->update([
                'estado' => 0
            ]);

            $message = 'Producto Eliminado';
        } else {
            # code...
            Producto::where('id',$producto->id)
            ->update([
                'estado' => 1
            ]);

            $message = 'Producto Restaurado';
        }
        
        return redirect()->route('producto.index')->with('success', $message);
    }
}
