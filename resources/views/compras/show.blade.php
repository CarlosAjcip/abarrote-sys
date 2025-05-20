@extends('template')

@section('title','Ver Compra')

@push('css')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Ver Compra</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('compras.index')}}">Compras</a></li>
        <li class="breadcrumb-item active">Ver Compra</li>
    </ol>
</div>

<div class="container w-100  p-4 mt-3">


    {{-- Tipo Comprobante --}}
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                <input type="text" name="" id="" class="form-control" value="Tipo Comprobante:" disabled>
            </div>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="{{$compras->comprobante->tipo_comprobante}}" disabled name=""
                id="">
        </div>
    </div>

    {{-- Numero Comprobante --}}
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                <input type="text" name="" id="" class="form-control" value="Numero Comprobante:" disabled>
            </div>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="{{$compras->numero_comprobante}}" disabled name="" id="">
        </div>
    </div>

    {{-- Proveedor --}}
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
                <input type="text" name="" id="" class="form-control" value="Proveedor:" disabled>
            </div>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="{{$compras->proveedore->persona->razon_social}}" disabled>
        </div>
    </div>

    {{-- Fecha --}}
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                <input type="text" name="" id="" class="form-control" value="Fecha:" disabled>
            </div>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control"
                value="{{ \Carbon\Carbon::parse($compras->fecha_hora)->format('d-m-Y') }}" disabled>
        </div>
    </div>

    {{-- Hoara --}}
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                <input type="text" name="" id="" class="form-control" value="Hora:" disabled>
            </div>
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control"
                value="{{ \Carbon\Carbon::parse($compras->fecha_hora)->format('H:i') }}" disabled>
        </div>
    </div>

    {{-- Impuesto --}}
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                <input type="text" name="" id="" class="form-control" value="Impuesto:" disabled>
            </div>
        </div>
        <div class="col-sm-8">
            <input id="input-impuesto" type="text" class="form-control" value="{{ $compras->impuesto}}" disabled>
        </div>
    </div>


    {{-- tabla --}}

    <div class="card mb-4">
        <div class="card-header">
            <i class="fa fa-table me-1"></i>
            Tabla de detale de la compra
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio de compra</th>
                        <th>Precio de venta</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras->productos as $item)
                        <tr>
                            <td>{{$item->nombre}}</td>
                            <td>{{$item->pivot->cantidad}}</td>
                            <td>{{$item->pivot->precio_compra}}</td>
                            <td>{{$item->pivot->precio_venta}}</td>
                            <td class="td-subtotal">{{($item->pivot->cantidad) * ($item->pivot->precio_compra)}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5"></th>
                    </tr>
                    <tr>
                        <th colspan="4">Sumas:</th>
                        <th id="th_suma"></th>
                    </tr>
                    <tr>
                        <th colspan="4">IGV:</th>
                        <th id="th_igv"></th>
                    </tr>
                    <tr>
                        <th colspan="4">Total:</th>
                        <th id="th_total"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>



@endsection

@push('js')
<script>
    let filasSubtotal = document.getElementsByClassName('td-subtotal');
    let cont = 0;
    let impuesto = $('#input-impuesto').val();

   $(document).ready(function(){
        calcularValores();
   });

   function calcularValores(){
    for (let i = 0; i < filasSubtotal.length; i++) {
        let valor = parseFloat(filasSubtotal[i].innerHTML);
        cont += valor;
    }
    $('#th_suma').html(cont);
    $('#th_igv').html(impuesto);
    $('#th_total').html(cont + parseFloat(impuesto));
    }

</script>
@endpush