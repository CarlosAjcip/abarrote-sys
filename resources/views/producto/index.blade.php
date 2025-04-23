@extends('template')

@section('titl','Productos')

@push('css')
<script src="tthps://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="tthps://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')

@if (session('success'))
<script>
    let message = "{{session('success')}}"
                const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
            });
            Toast.fire({
            icon: "success",
            title: message
            });
</script>
@endif

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Productos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">producto</li>
    </ol>

    <div class="mb-4">
        <a href="{{route('producto.create')}}"><button type="button" class="btn btn-primary">Nuevo
                Registro</button></a>
    </div>


    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            tabla productos
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Presentacion</th>
                        <th>Categorias</th>
                        <th>Acciones</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $item)
                    <tr>
                        <td>{{$item->codigo}}</td>
                        <td>{{$item->nombre}}</td>
                        <td>
                            {{$item->marca->caracteristica->nombre}}
                        </td>
                        <td>
                            {{$item->presentacion->caracteristica->nombre}}
                        </td>
                        <td>
                            @foreach ($item->categorias as $category)
                            <div class="container">
                                <div class="row">
                                    <span class="m-1 rounded-pill p-1 bg-secondary text-white text-center">
                                        {{$category->caracteristica->nombre}}</span>
                                </div>
                            </div>
                            @endforeach
                        </td>
                        <td>
                            @if ($item->estado == 1)
                            <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>
                            @else
                            <span class="fw-bolder p-1 rounded bg-danger text-white">Eliminado</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                                <form method="get" action="{{route('presentaciones.edit',['presentaciones'=>$item])}}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Editar</button>
                                </form>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verModal-{{$item->id}}">Ver</button>

                                @if ($item->estado == 1)
                                <button type="button" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-{{$item->id}}"
                                    class="btn btn-danger">Eliminar</button>
                                @else
                                <button type="button" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-{{$item->id}}"
                                    class="btn btn-success">Restaurar</button>
                                @endif

                            </div>
                        </td>
                    </tr>

                    <!-- Modal -->
                    {{-- <div class="modal fade" id="exampleModal-{{$item->id}}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmacion</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{ $presentaciones->caracteristica->estado == 1
                                    ? "!¿Seguro que quieres eliminar la presentacion?"
                                    : "¿Quieres restaurar la presentacion?"
                                    }}

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <form method="post"
                                        action="{{route('presentaciones.destroy',['presentaciones'=>$item->id])}}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Modal de ver la imagne-->
                    <div class="modal fade" id="verModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                 <div class="row mb-3">
                                    <label for=""><span class="fw-bolder">Descripcion:</span> {{$item->descripcion}}</label>
                                    <div class="row mb-3">
                                        <label for=""><span class="fw-bolder">Fecha Vencimiento: </span>{{$item->fecha_vencimiento == '' ? 'No tiene' :  $item->fecha_vencimiento}}</label>
                                    </div>

                                    <div class="row mb-3">
                                        <label><span class="fw-bolder">Stock: </span>{{$item->stock}}</label>
                                    </div>

                                    <div class="row mb-3">
                                        <label  class="fw-bolder">Imagen:</label>
                                        <div>
                                            @if ($item->img_path != null)
                                                <img src="{{Storage::url('public/productos/'. $item->img_path)}}" alt="{{$item->nombre}}" class="img-fluid img-thumbnail border boder-4 rounded">
                                            @else
                                                <img src="" alt="{{$item->nombre}}">
                                            @endif
                                        </div>
                                    </div>
                                 </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="tthps://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{asset('js/datatables-simple-demo.js')}}"></script>
@endpush