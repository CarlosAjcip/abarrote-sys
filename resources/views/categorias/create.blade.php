@extends('template')

@section('title', 'Crear categoria')

@push('css')
  <style>
    #descripcion{
        resize: none
    }
  </style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Categorias</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('categoria.index')}}">categorias</a></li>
        <li class="breadcrumb-item active">crear</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('categoria.store')}}" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" value="{{@old('nombre')}}">
                        @error('nombre')
                            <small class="text-danger">{{'*'. $message}}</small>
                        @enderror
                </div>

                <div class="col-md-12">
                    <label for="descripcion" class="form-label">Descripcion:</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{@old('descripcion')}}</textarea>
                    @error('descripcion')
                    <small class="text-danger">{{'*'. $message}}</small>
                @enderror
                </div>

                <div class="col-12 col-md-6 mx-auto text-center">
                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
                </div>
                
            </div>
        </form>
    </div>
    
</div>
@endsection

@push('js')
    
@endpush