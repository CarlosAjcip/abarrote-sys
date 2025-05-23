<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;

    public function compras()
    {
        return $this->belongsToMany(Compra::class)
        ->withTimestamps()
        ->withPivot('cantidad','precio_compra','precio_venta');
    }

    public function ventas(){
        return $this->belongsToMany(Venta::class)
        ->withTimestamps()
        ->withPivot('cantidad','precio_venta','descuento');
    }

    public function categorias(){
        return $this->belongsToMany(Categoria::class)
        ->withTimestamps();
    }

    public function marca(){
        return $this->belongsTo(Marca::class);
    }

    public function presentacion(){
        return $this->belongsTo(Presentacion::class);
    }

    protected $fillable = ['codigo','nombre','descripcion','fecha_vencimiento','marca_id','presentacion_id','img_path'];

    public function handleUploadImage($image)
{
    $file = $image;
    $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();


    //$file->move(public_path('/img/productos'), $name);
    Storage::putFileAs('/public/productos/',$file,$name,'public');
    return $name;
}

}
