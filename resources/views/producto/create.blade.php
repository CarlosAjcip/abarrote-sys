@extends('template')

@section('title','Crear producto')

@push('css')
  <style>
    #descripcion{
        resize: none
    }
  </style>
 {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}
 <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Productos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('producto.index')}}">productos</a></li>
        <li class="breadcrumb-item active">crear</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('producto.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6 mb-2">
                    <label for="codigo" class="form-label">Codigo:</label>
                    <input type="text" name="codigo" id="codigo" class="form-control"  value="{{@old('codigo')}}">
                    @error('codigo')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-2">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control"  value="{{@old('nombre')}}">
                    @error('nombre')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="descripcion" class="form-label">Descripcion:</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="form-control">{{@old('descripcion')}}</textarea>
                    @error('descripcion')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                {{-- Descripcion --}}
                <div class="col-md-6 mb-2">
                    <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento:</label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control"  value="{{@old('fecha_vencimiento')}}">
                    @error('fecha_vencimiento')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>

                {{-- imagenes --}}
                <div class="col-md-6 mb-2">
                    <label for="img_path" class="form-label">Imagen:</label>
                    <input type="file" name="img_path" accept="image/*" id="img_path" class="form-control"  value="{{@old('img_path')}}">
                    @error('img_path')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>

                  {{-- imagenes --}}
                  <div class="col-md-6 mb-2">
                    <label for="marca_id" class="form-label">Marca:</label>
                   
                    <select  name="marca_id" id="marca_id" class="form-control">
                        <option value="" disabled selected>-- Selecciona una marca --</option>
                        @foreach ($marcas as $item)
                            <option value="{{$item->id}}" {{@old('marca_id') == $item->id ? 'selected' : ''}}>{{$item->nombre}}</option>
                        @endforeach
                    </select>
                    @error('marca_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>

                   {{-- imagenes --}}
                   <div class="col-md-6 mb-2">
                        <label for="presentacion_id" class="form-label">Presentaciones:</label>
                        <select name="presentacion_id" id="presentacion_id" class="form-control">
                            <option value="" disabled selected>-- Selecciona una presentación --</option>
                            @foreach ($presentaciones as $item)
                                <option value="{{ $item->id }}" {{ old('presentacion_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('presentacion_id')
                        <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="categorias" class="form-label">Categorías:</label>
                        <select multiple name="categorias[]" id="categorias" class="form-control select2">
                            <option disabled>-- Selecciona una o más categorías --</option>
                            @foreach ($categorias as $item)
                                <option value="{{ $item->id }}" {{(in_array($item->id,old('categorias',[]))) ? 'selected' : ''}}>{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                        @error('categorias')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>
                    

                    <div class="col-12 mx-auto text-center">
                        <button type="submit" class="btn btn-primary w-100">Guardar</button>
                    </div>
                    
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script> --}}
<!-- jQuery (necesario para Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#categorias').select2({
            placeholder: 'Selecciona una o más categorías',
            allowClear: true,
            width: '100%'
        });
    });
</script>


@endpush