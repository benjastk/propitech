@extends('back-office.layouts.app')
@section('css')
<style>
    .expandChildTable:before {
        content: "+";
        display: block;
        cursor: pointer;
    }
    .expandChildTable.selected:before {
        content: "-";
    }
    .childTableRow {
        display: none;
    }
    .childTableRow table {
        border: 2px solid #555;
    }
</style>
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Pagos por estado</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">

                    <div class="col-md-3">
                        <label>Desde</label>
                        <input type="date" class="form-control" id="fecha_desde">
                    </div>

                    <div class="col-md-3">
                        <label>Hasta</label>
                        <input type="date" class="form-control" id="fecha_hasta">
                    </div>

                    <div class="col-md-4">
                        <label>Estado</label>
                        <select class="form-control" id="estado">
                            <option value="">Seleccione</option>
                            @foreach($estados as $estado)
                            <option value="{{ $estado->idEstado }}">{{ $estado->nombreEstado }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" id="btnBuscar">
                            Buscar
                        </button>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">NOMBRE</th>
                                                <th scope="col">RUT</th>
                                                <th scope="col">DIRECCION</th>
                                                <th scope="col">DEPARTAMENTO</th>
                                                <th scope="col">TOTAL A PAGAR</th>
                                                <th scope="col">TOTAL PAGADO</th>
                                                <th scope="col">SALDO</th>
                                                <th scope="col">ESTADO</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
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
@endsection
@section('script')
<script>
    document.getElementById('btnBuscar').addEventListener('click', function () {
        let desde = document.getElementById('fecha_desde').value;
        let hasta = document.getElementById('fecha_hasta').value;
        let estado = document.getElementById('estado').value;

        if(!desde || !hasta || !estado){
            alert('Debe completar todos los campos');
            return;
        }

        fetch("{{ route('pagos.filtrar') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                desde: desde,
                hasta: hasta,
                estado: estado
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.length > 0)
            {
                let tbody = document.querySelector('tbody');
                tbody.innerHTML = '';
                data.forEach(item => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${item.name ?? '' } ${item.apellido ?? ''}</td>
                            <td>${item.rut ?? ''}</td>
                            <td>${item.direccion ?? '' } ${item.numero ?? ''}</td>
                            <td>${item.block ?? '' }</td>
                            <td>$${Number(item.subtotal).toLocaleString('es-CL')}</td>
                            <td>$${Number(item.totalPagado).toLocaleString('es-CL')}</td>
                            <td>$${Number(item.saldo).toLocaleString('es-CL')}</td>
                            <td>${item.fechaVencimiento ? new Date(item.fechaVencimiento).toLocaleDateString('es-CL') : '' }</td>
                            <td>${item.nombreEstado ?? ''}</td>
                        </tr>
                    `;
                });
            }
            else
            {
                let tbody = document.querySelector('tbody');
                tbody.innerHTML = '<tr><td colspan="9" style="text-align:center" >SIN DATOS</td></tr>';
            }
        });

    });
</script>
@endsection