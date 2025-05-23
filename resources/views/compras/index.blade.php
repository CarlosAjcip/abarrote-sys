@extends('template')
@section('title','compras')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
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
    <h1 class="mt-4 text-center">Compras</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">compras</li>
    </ol>

    <div class="mb-4">
        <a href="{{route('compras.create')}}"><button type="button" class="btn btn-primary">Nuevo  Registro</button></a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla compras
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Comprobante</th>
                        <th>Proveedor</th>
                        <th>Fecha y Hora</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $item)
                        <tr>
                            <td>
                                <p class="fw-semibold mb-1">{{$item->comprobante->tipo_comprobante}}</p>
                                <p class="text-muted mb-0">{{$item->numero_comprobante}}</p>
                            </td>
                            <td>
                                <p class="fw-semibold mb-1">{{ucfirst($item->proveedore->persona->tipo_persona)}}</p>
                                <p class="tet-muted mb-0">{{$item->proveedore->persona->razon_social}}</p>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->fecha_hora)->format('d-m-Y') }}
                                    {{ \Carbon\Carbon::parse($item->fecha_hora)->format('H:i') }}
                            </td>
                            <td>
                                {{$item->total}}
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <form action="{{route('compras.show', ['compras'=>$item])}}" method="get">
                                        <button type="submit" class="btn btn-success" >ver</button>   
                                    </form>
                                   
                                   <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-{{$item->id}}">Eliminar</button>   
                                                                      
                                </div>
                            </td>
                        </tr>


                    <!-- Modal Eliminar-->
                    <div class="modal fade" id="exampleModal-{{$item->id}}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmacion</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    !¿Seguro que quieres eliminar el cliente?

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    <form method="post"
                                        action="{{route('compras.destroy',['compras'=>$item->id])}}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                    </form>

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
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{asset('js/datatables-simple-demo.js')}}"></script>
@endpush