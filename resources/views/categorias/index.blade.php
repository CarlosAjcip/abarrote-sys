@extends('template')
@section('title','categorias')

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
    <h1 class="mt-4 text-center">Categorias</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">categorias</li>
    </ol>

    <div class="mb-4">
        <a href="{{route('categoria.create')}}"><button type="button" class="btn btn-primary">Nuevo
                Registro</button></a>
    </div>


    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Example
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                        <tr>
                            <td>{{$categoria->caracteristica->nombre}}</td>
                            <td>
                                {{$categoria->caracteristica->descripcion}}
                            </td>
                            <td>
                                @if ($categoria->caracteristica->estado == 1)
                                    <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>
                                @else
                                <span class="fw-bolder p-1 rounded bg-danger text-white">Eliminado</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                   <form method="get" action="{{route('categoria.edit',['categoria'=>$categoria])}}">
                                    @csrf   
                                    <button type="submit" class="btn btn-warning">Editar</button>   
                                   </form>
                                   @if ($categoria->caracteristica->estado == 1)
                                   <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$categoria->id}}" class="btn btn-danger">Eliminar</button>   
                                   @else
                                   <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$categoria->id}}" class="btn btn-success">Restaurar</button>
                                   @endif
                                    
                                  
                                </div>
                            </td>
                        </tr>


<!-- Modal -->
<div class="modal fade" id="exampleModal-{{$categoria->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmacion</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {{ $categoria->caracteristica->estado == 1 
                ? "!¿Seguro que quieres eliminar la categoría? " 
                : "¿Quieres restaurar la categoría?" 
            }}
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <form method="post" action="{{route('categoria.destroy',['categoria'=>$categoria->id])}}">
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