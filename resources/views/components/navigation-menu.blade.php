<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Inicio</div>
                <a class="nav-link" href="{{route('panel')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Panel
                </a>
                <div class="sb-sidenav-menu-heading">Modulos</div>
                   {{-- <div class="sb-sidenav-menu-heading">Interface</div> --}}
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-store"></i></div>
                    Compras
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{route('compras.index')}}">Ver</a>
                        <a class="nav-link" href="{{route('compras.create')}}">Crear</a>
                    </nav>
                </div>
            
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutss" aria-expanded="false" aria-controls="collapseLayoutss">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-plus"></i></div>
                    Ventas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayoutss" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{route('venta.index')}}">Ver</a>
                        <a class="nav-link" href="{{route('venta.create')}}">Crear</a>
                    </nav>
                </div>
                <a class="nav-link" href="{{route('categoria.index')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                    Categorias
                </a>
                <a class="nav-link" href="{{route('marca.index')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-tags"></i></div>
                    Marcas
                </a>
                <a class="nav-link" href="{{route('presentaciones.index')}}">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-file"></i></i></div>
                    Presentaciones
                </a>
                <a class="nav-link" href="{{route('producto.index')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-seedling"></i></div>
                    Productos
                </a>
                <a class="nav-link" href="{{route('cliente.index')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                    Clientes
                </a>
                <a class="nav-link" href="{{route('proveedores.index')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                    Proveedores
                </a>

                
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Bienvenido:</div>
        </div>
    </nav>
</div>