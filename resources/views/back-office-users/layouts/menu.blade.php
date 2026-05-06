<div class="db-sidebar">
    <nav class="navbar navbar-expand-xl navbar-light d-block px-0 header-sticky dashboard-nav py-0">
    <div class="sticky-area shadow-xs-1 py-3 sidebar-bg" style="">
        <div class="d-flex px-3 px-xl-6 w-100">
        <a class="navbar-brand" href="/home-users">
            <img src="front/LOGOPROPITECHby.png" alt="Propitech">
        </a>
        <div class="ml-auto d-flex align-items-center ">
            <div class="d-flex align-items-center d-xl-none">
            <div class="dropdown px-3">
                <a href="#" class="dropdown-toggle d-flex align-items-center text-heading"
                    data-toggle="dropdown">
                <div class="w-48px">
                    @if($user->avatarImg)
                        <img class="rounded-circle header-profile-user" src="/img/usuarios/{{ $user->avatarImg }}" alt="Header Avatar">
                    @else
                        <img class="rounded-circle header-profile-user" src="/images/userTransparent.png" alt="Header Avatar">
                    @endif
                </div>
                <span class="fs-13 font-weight-500 d-none d-sm-inline ml-2">
                    {{ $user->name }} {{ $user->apellido }}
                </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">My Profile</a>
                <a class="dropdown-item" href="#">My Profile</a>
                <a class="dropdown-item" href="#">Logout</a>
                </div>
            </div>
            <div class="dropdown no-caret py-4 px-3 d-flex align-items-center notice mr-3">
                <a href="#" class="dropdown-toggle text-heading fs-20 font-weight-500 lh-1"
                    data-toggle="dropdown">
                <i class="far fa-bell"></i>
                <span class="badge badge-primary badge-circle badge-absolute font-weight-bold fs-13">1</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
            </div>
            <button class="navbar-toggler border-0 px-0" type="button" data-toggle="collapse"
                data-target="#primaryMenuSidebar"
                aria-controls="primaryMenuSidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        </div>
        <div class="collapse navbar-collapse " id="primaryMenuSidebar">
        <!--<form class="d-block d-xl-none pt-5 px-3">
            <div class="input-group">
            <div class="input-group-prepend mr-0 bg-input">
                <button class="btn border-0 shadow-none fs-20 text-muted pr-0" type="submit"><i
                        class="far fa-search"></i></button>
            </div>
            <input type="text" class="form-control border-0 form-control-lg shadow-none"
                    placeholder="Search for..." name="search">
            </div>
        </form>-->
        <ul class="list-group list-group-flush w-100" style="">
            <li class="list-group-item pt-6 pb-4" style="">
            <h5 class="fs-13 letter-spacing-087 mb-3 text-uppercase px-3 text-white" style="font-weight: 700;" >Dashboard</h5>
            <ul class="list-group list-group-no-border rounded-lg" style="">
                <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item" style="">
                <a href="/home-users" class="text-heading lh-1 sidebar-link">
                    <span class="sidebar-item-icon d-inline-block mr-3 fs-20 text-white"><i
                                class="fal fa-cog"></i></span>
                    <span class="sidebar-item-text text-white">Dashboard</span>
                </a>
                </li>
            </ul>
            </li>
            <li class="list-group-item pt-6 pb-4" style="">
            <h5 class="fs-13 letter-spacing-087 mb-3 text-uppercase px-3 text-white" style="font-weight: 700;">Propiedades</h5>
            <ul class="list-group list-group-no-border rounded-lg">
                <!--<li class="list-group-item px-3 px-xl-4 py-2 sidebar-item" style="">
                <a href="dashboard-add-new-property.html"
                        class="text-heading lh-1 sidebar-link">
                    <span class="sidebar-item-icon d-inline-block mr-3 fs-20 fs-20">
                    <svg class="icon icon-add-new text-white"><use
                                    xlink:href="#icon-add-new"></use></svg></span>
                    <span class="sidebar-item-text text-white">Add new</span>
                </a>
                </li>-->
                <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item" style="">
                <a href="dashboard-my-properties.html"
                        class="text-heading lh-1 sidebar-link d-flex align-items-center">
                    <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                    <svg class="icon icon-my-properties text-white"><use
                                    xlink:href="#icon-my-properties"></use></svg>
                    </span>
                    <span class="sidebar-item-text text-white">Mis propiedades</span>
                </a>
                </li>
                <!--<li class="list-group-item px-3 px-xl-4 py-2 sidebar-item" style="">
                <a href="dashboard-my-favorites.html"
                        class="text-heading lh-1 sidebar-link d-flex align-items-center">
                    <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                    <svg class="icon icon-heart text-white"><use xlink:href="#icon-heart"></use></svg>
                    </span>
                    <span class="sidebar-item-text text-white">My Favorites</span>
                </a>
                </li>
                <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item" style="">
                <a href="dashboard-save-search.html"
                        class="text-heading lh-1 sidebar-link d-flex align-items-center">
                    <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                    <svg class="icon icon-save-search text-white"><use xlink:href="#icon-save-search"></use></svg>
                    </span>
                    <span class="sidebar-item-text text-white">Save Search</span>
                </a>
                </li>-->
                <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item" style="">
                <a href="dashboard-reviews.html"
                        class="text-heading lh-1 sidebar-link d-flex align-items-center">
                    <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                    <svg class="icon icon-money text-white"><use xlink:href="#icon-money"></use></svg>
                    </span>
                    <span class="sidebar-item-text text-white">Pagos mensuales</span>
                </a>
                </li>
            </ul>
            </li>
            <li class="list-group-item pt-6 pb-4" style="">
            <h5 class="fs-13 letter-spacing-087 mb-3 text-uppercase px-3 text-white" style="font-weight: 700;">Información personal</h5>
            <ul class="list-group list-group-no-border rounded-lg">
                <!--<li class="list-group-item px-3 px-xl-4 py-2 sidebar-item" style="">
                <a href="dashboard-my-packages.html"
                        class="text-heading lh-1 sidebar-link d-flex align-items-center">
                    <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                    <svg class="icon icon-my-package text-white"><use xlink:href="#icon-my-package"></use></svg>
                    </span>
                    <span class="sidebar-item-text text-white">My Package</span>
                    <span class="sidebar-item-number ml-auto text-primary fs-15 font-weight-bold">5</span>
                </a>
                </li>-->
                <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item" style="">
                <a href="dashboard-my-profiles.html"
                        class="text-heading lh-1 sidebar-link">
                    <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                    <svg class="icon icon-my-profile text-white"><use xlink:href="#icon-my-profile"></use></svg>
                    </span>
                    <span class="sidebar-item-text text-white">Mi Información
                    </span>
                </a>
                </li>
                <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item" style="">
                <a href="dashboard-my-profiles.html"
                        class="text-heading lh-1 sidebar-link">
                    <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                    <svg class="icon icon-price text-white"><use xlink:href="#icon-price"></use></svg>
                    </span>
                    <span class="sidebar-item-text text-white">Cuentas corrientes</span>
                </a>
                </li>
                <li class="list-group-item px-3 px-xl-4 py-2 sidebar-item" style="">
                <a href="#" class="text-heading lh-1 sidebar-link">
                    <span class="sidebar-item-icon d-inline-block mr-3 text-muted fs-20">
                    <svg class="icon icon-log-out text-white"><use xlink:href="#icon-log-out"></use></svg>
                    </span>
                    <span class="sidebar-item-text text-white">Cerrar sesión</span>
                </a>
                </li>
            </ul>
            </li>
        </ul>
        </div>
    </div>
    </nav>
</div>