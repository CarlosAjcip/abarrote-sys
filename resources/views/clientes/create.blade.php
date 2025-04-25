@extends('template')

@section('title', 'Crear cliente')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <style>
    #box-razon-social{
        display: none
    }
  </style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Cliente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('cliente.index')}}">clientes</a></li>
        <li class="breadcrumb-item active">crear</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('cliente.store')}}" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                        <label for="tipo_persona" class="form-label">Tipo Cliente:</label>
                        <select name="tipo_persona" id="tipo_persona" class="form-select">
                            <option value="" selected disabled>Seleccione un opcion</option>
                            <option value="natural" {{old('tipo_persona') == 'natural' ? 'selected' : ''}}>Persona natural</option>
                            <option value="juridica" {{old('tipo_persona') == 'juridica' ? 'selected' : ''}}>Persona juridica</option>
                        </select>
                        @error('tipo_persona')
                            <small class="text-danger">{{'*'. $message}}</small>
                        @enderror
                </div>

                <div class="col-md-12 mb-2" id="box-razon-social">
                    <label id="label-natural" for="razon_social" class="form-label">Nombres y Apellidos</label>
                    <label id="label-juridica" for="razon_social" class="form-label">Nombre de la empresa</label>

                    <input type="text" name="razon_social" class="form-control" value="{{old('razon_social')}}">

                    @error('razon_social')
                    <small class="text-danger">{{'*'. $message}}</small>
                    @enderror
                </div>

                <div class="col-md-12 mb-2">
                    <label for="direccion" class="form-label">Direccion:</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion')}}">
                    @error('direccion')
                    <small class="text-danger">{{'*'. $message}}</small>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                            <label for="documento_id" class="form-label">Tipo Documento:</label>
                            <select name="documento_id" id="documento_id" class="form-select">
                                <option value="" selected disabled>Seleccione un opcion</option>
                                @foreach ($documentos as $item)
                                    <option  {{old('documento_id') == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->tipo_documento}}</option>                                    
                                @endforeach
                            </select>
                            @error('documento_id')
                                <small class="text-danger">{{'*'. $message}}</small>
                            @enderror
                    </div>

                    
                    <div class="col-md-6">
                        <label for="numero_documento" class="form-label">Numero de Documento:</label>
                        <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{old('numero_documento')}}">
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
    <script>
        $(document).ready(function () {
            $('#tipo_persona').on('change',function () {
                let selectValue = $(this).val();

                if (selectValue == 'natural') {
                    $('#label-juridica').hide();
                    $('#label-natural').show();
                }else{
                    $('#label-natural').hide();
                    $('#label-juridica').show();
                }

                $('#box-razon-social').show();
            })
        })
    </script>
@endpush