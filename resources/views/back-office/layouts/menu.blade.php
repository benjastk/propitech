<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">     
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li>
                    <a href="/home" class="waves-effect">
                        <i class="bx bx-home-circle"></i><!--<span class="badge badge-pill badge-info float-right">03</span>-->
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/users" class="waves-effect">
                        <i class="bx bx-user"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="/properties" class="waves-effect">
                        <i class="bx bxs-home"></i>
                        <span>Propiedades</span>
                    </a>
                </li>
                <li>
                    <a href="/reservas" class="waves-effect">
                        <i class="bx bx-food-menu"></i>
                        <span>Reservas de Propiedades</span>
                    </a>
                </li>
                <li>
                    <a href="/contratos" class="waves-effect">
                        <i class="bx bxs-file"></i>
                        <span>Contratos de arriendo</span>
                    </a>
                </li>
                <li>
                    <a href="/mandatos" class="waves-effect">
                        <i class="bx bxs-home-circle"></i>
                        <span>Mandatos de Administracion</span>
                    </a>
                </li>
                <li>
                    <a href="/noticias" class="waves-effect">
                        <i class="bx bxs-news"></i>
                        <span>Publicaciones</span>
                    </a>
                </li>
                <li>
                    <a href="/planes" class="waves-effect">
                        <i class="bx bxs-dollar-circle"></i>
                        <span>Planes de administración</span>
                    </a>
                </li>
                @if($user->id)
                <li>
                    <a href="/parametros" class="waves-effect">
                        <i class="bx bxs-cog"></i>
                        <span>Parametros Generales</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="/leads" class="waves-effect">
                        <i class="bx bx-voicemail"></i>
                        <span>Interacciones Web</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>