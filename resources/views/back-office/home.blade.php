@extends('back-office.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Dashboard</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard - {{ $hora }}</a></li>
                                </ol>
                                @if($actulizacionBuyDepa)
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">ULTIMA ACTUALIZACION BUY DEPA - {{ $actulizacionBuyDepa->created_at }}</a></li>
                                </ol>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted font-weight-medium">Propiedades para venta</p>
                                                <h4 class="mb-0">{{ $propiedadesVenta }}</h4>
                                            </div>

                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-home-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body" style="height: 120px;" >
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted font-weight-medium">Propiedades para Arriendo</p>
                                                <h4 class="mb-0">{{ $propiedadesArriendo }}</h4>
                                            </div>

                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-warning">
                                                    <i class="bx bxs-home font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted font-weight-medium">Contratos en arriendo</p>
                                                <h4 class="mb-0">{{ $contratosArriendos }}</h4>
                                            </div>

                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                                <span class="avatar-title">
                                                    <i class="bx bxs-file font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media">
                                            <div class="media-body">
                                                <p class="text-muted font-weight-medium">Mandatos de administracion</p>
                                                <h4 class="mb-0">{{ $mandatosAdministracion }}</h4>
                                            </div>

                                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="fas fa-file-signature font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4 float-sm-left">Contactos recibidos por la Web</h4>
                                        <!--<div class="float-sm-right">
                                            <ul class="nav nav-pills">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#">Week</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#">Month</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#">Year</a>
                                                </li>
                                            </ul>
                                        </div>-->
                                        <div class="clearfix"></div>
                                        <div id="stacked-column-chart" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Propitech.
                    </div>
                    <div class="col-sm-6">
                        <!--<div class="text-sm-right d-none d-sm-block">
                            Design & Develop by Themesbrand
                        </div>-->
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title px-3 py-4">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
            <h5 class="m-0">Settings</h5>
        </div>

        <!-- Settings -->
        <hr class="mt-0" />
        <h6 class="text-center mb-0">Choose Layouts</h6>

        <div class="p-4">
            <div class="mb-2">
                <img src="images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="custom-control custom-switch mb-3">
                <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch" checked />
                <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
            </div>

            <div class="mb-2">
                <img src="images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="custom-control custom-switch mb-3">
                <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch" data-bsStyle="css/bootstrap-dark.min.css" data-appStyle="css/app-dark.min.css" />
                <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
            </div>

            <div class="mb-2">
                <img src="images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="custom-control custom-switch mb-5">
                <input type="checkbox" class="custom-control-input theme-choice" id="rtl-mode-switch" data-appStyle="css/app-rtl.min.css" />
                <label class="custom-control-label" for="rtl-mode-switch">RTL Mode</label>
            </div>

    
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div> <!-- end slimscroll-menu-->
</div>
@endsection
@section('script')
<!-- apexcharts -->
<script src="/libs/apexcharts/apexcharts.min.js"></script>
<script>
    $(document).ready( function () {
		
	} );
    var options={
        chart:{
            height:359,
            type:"bar",
            zoom:
            {
                enabled:!0
            }
        },
        plotOptions:
        {
            bar:
            {
                horizontal: !1,
                columnWidth: "15%",
            }
        },
        series:
        [
            {
                name:"Cantidad",
                data:
                [
                    @if($leadsContactos)
                    @foreach($leadsContactos as $leadContacto)
                    {{ $leadContacto->cantidadLeads }},
                    @endforeach
                    @endif
                ]
            },
        ],
        xaxis:
        {
            categories:
            [
                @if($leadsContactos)
                @foreach($leadsContactos as $leadContacto)
                
                    "{{ $leadContacto->fecha }}",
                
                @endforeach
                @endif
        ]
        },
        colors:
        [
            "#556ee6"
        ],
        legend:
        {
            position:"bottom"
        },
        fill:
        {
            opacity:1
        },
        labels: 
        {
            rotate: 0,
            rotateAlways: false,
            formatter: function (val) 
            {
                return val.toFixed(0);
            }
        },
        decimalsInFloat: 0,
    };
    (chart=new ApexCharts(document.querySelector("#stacked-column-chart"),options)).render();
</script>
@endsection