@extends('template')

@section('title', 'Editar Proveedor')

@push('css')

@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Proveedor</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('proveedores.index')}}">proveedores</a></li>
        <li class="breadcrumb-item active">editar</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('proveedores.update', ['proveedores' => $proveedores])}}" method="post">
            @method('PATCH')
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                        <label for="tipo_persona" class="form-label">Tipo proveedore: <span class="fw-bold">{{Str::upper($proveedores->persona->tipo_persona)}}</span></label>
                </div>

                <div class="col-md-12 mb-2" id="box-razon-social">
                    @if ($proveedores->persona->tipo_persona == 'natural')
                    <label id="label-natural" for="razon_social" class="form-label">Nombres y Apellidos</label>
                    @else
                    <label id="label-juridica" for="razon_social" class="form-label">Nombre de la empresa</label>    
                    @endif

                    <input type="text" name="razon_social" class="form-control" value="{{old('razon_social', $proveedores->persona->razon_social)}}">

                    @error('razon_social')
                    <small class="text-danger">{{'*'. $message}}</small>
                    @enderror
                </div>

                <div class="col-md-12 mb-2">
                    <label for="direccion" class="form-label">Direccion:</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion', $proveedores->persona->direccion)}}">
                    @error('direccion')
                    <small class="text-danger">{{'*'. $message}}</small>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                            <label for="documento_id" class="form-label">Tipo Documento:</label>
                            <select name="documento_id" id="documento_id" class="form-select">
                                
                                @foreach ($documentos as $item)
                                    @if ($proveedores->persona->documento_id == $item->id)
                                        <option selected  {{old('documento_id') == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->tipo_documento}}</option>                                        
                                    @else
                                        <option   {{old('documento_id') == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->tipo_documento}}</option>                                    
                                    @endif
                                    
                                @endforeach
                            </select>
                            @error('documento_id')
                                <small class="text-danger">{{'*'. $message}}</small>
                            @enderror
                    </div>

                    
                    <div class="col-md-6">
                        <label for="numero_documento" class="form-label">Numero de Documento:</label>
                        <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{old('numero_documento', $proveedores->persona->numero_documento)}}">
                        @error('numero_documento')
                        <small class="text-danger">{{'*'. $message}}</small>
                        @enderror
                    </div>


                <div class="col-12  mx-auto text-center">
                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
                </div>
                
            </div>
        </form>
    </div>
    
</div>
@endsection

@push('js')

@endpush