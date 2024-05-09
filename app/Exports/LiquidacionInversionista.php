<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\EstadosPagosMandatarios;
use App\EstadoPago;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Protection;

class LiquidacionInversionista implements FromView, ShouldAutoSize, WithStyles, WithEvents
{
    protected $mes;
    protected $anio;
    protected $dia;
    protected $tipo;
    public function __construct($mes, $anio, $tipo) 
    {
        $this->mes = $mes;
        $this->anio = $anio;
        $this->tipo = $tipo;
    }
    public function styles(Worksheet $sheet)
    {
        if($this->tipo == 1)
        {
            $estadosPagosMandatarios = EstadosPagosMandatarios::select('propiedades.nombrePropiedad', 'mandatos_propiedad.nombrePropietario', 
                    'mandatos_propiedad.apellidoPropietario', 'mandatos_propiedad.rutPropietario', 'mandatos_propiedad.nombreArrendatario', 
                    'mandatos_propiedad.apellidoArrendatario', 'mandatos_propiedad.rutArrendatario', 'estados_pagos_mandatarios.montoAPagar', 
                    'estados_pagos_mandatarios.cargosAbonos', 'estados_pagos_mandatarios.montoPagado', 'estados_pagos_mandatarios.garantia', 
                    'estados_pagos_mandatarios.montoComision',  'estados_pagos_mandatarios.montoDeuda', 'estados_pagos_mandatarios.saldoArrastre', 
                    'estados_pagos_mandatarios.montoALiquidarPropietario', 'estados.nombreEstado','bancos.nombreBanco',
                    DB::raw('CONCAT(usuarios_cuentas_bancarias.numeroCuenta, ", ", bancos.nombreBanco) AS observaciones'), 'users.email', 
                    'estados_pagos_mandatarios.fechaLiquidado' , 'estados_pagos_mandatarios.idEstadoPago', 'estados_pagos_mandatarios.comisionCorretaje',
                    'planes.comisionAdministracion')
                    ->join('estados', 'estados_pagos_mandatarios.idEstado', '=', 'estados.idEstado')
                    ->join('mandatos_propiedad', 'estados_pagos_mandatarios.idMandatoPropiedad', '=', 'mandatos_propiedad.idMandatoPropiedad')
                    ->join('planes', 'planes.id', '=', 'mandatos_propiedad.idPlan')
                    ->join('propiedades', 'mandatos_propiedad.idPropiedad', '=', 'propiedades.id')
                    ->join('users', 'mandatos_propiedad.idPropietario', '=', 'users.id')
                    ->leftjoin('usuarios_cuentas_bancarias', 'mandatos_propiedad.idUsuarioCuentaBancaria', '=', 'usuarios_cuentas_bancarias.idUsuarioCuentaBancaria')
                    ->leftjoin('bancos', 'usuarios_cuentas_bancarias.idBanco', '=', 'bancos.idBanco')
                    //nueva linea
                    ->leftjoin('estados_pagos', 'estados_pagos_mandatarios.idEstadoPago', '=', 'estados_pagos.idEstadoPago')
                    ->leftjoin('pagos', 'estados_pagos.idEstadoPago', '=', 'pagos.idEstadoPago')
                    //fin
                    ->leftjoin('contratos_arriendos', 'mandatos_propiedad.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
                    ->whereIn('estados_pagos_mandatarios.idEstado', [67, 69])
                    ->whereMonth('estados_pagos_mandatarios.fechaDePago', '=', $this->mes)
                    ->whereYear('estados_pagos_mandatarios.fechaDePago', '=', $this->anio)
                    ->orderBy('mandatos_propiedad.nombrePropietario', 'ASC')
                    ->get();
        }
        else
        {
            $estadosPagosMandatarios = EstadosPagosMandatarios::select('propiedades.nombrePropiedad', 'mandatos_propiedad.nombrePropietario', 
                    'mandatos_propiedad.apellidoPropietario', 'mandatos_propiedad.rutPropietario', 'mandatos_propiedad.nombreArrendatario', 
                    'mandatos_propiedad.apellidoArrendatario', 'mandatos_propiedad.rutArrendatario', 'estados_pagos_mandatarios.montoAPagar', 
                    'estados_pagos_mandatarios.cargosAbonos', 'estados_pagos_mandatarios.montoPagado', 'estados_pagos_mandatarios.garantia', 
                    'estados_pagos_mandatarios.montoComision',  'estados_pagos_mandatarios.montoDeuda', 'estados_pagos_mandatarios.saldoArrastre', 
                    'estados_pagos_mandatarios.montoALiquidarPropietario', 'estados.nombreEstado','bancos.nombreBanco',
                    DB::raw('CONCAT(usuarios_cuentas_bancarias.numeroCuenta, ", ", bancos.nombreBanco) AS observaciones'), 'users.email', 
                    'estados_pagos_mandatarios.fechaLiquidado' , 'estados_pagos_mandatarios.idEstadoPago', 'estados_pagos_mandatarios.comisionCorretaje',
                    'propiedades.direccion', 'propiedades.numero', 'propiedades.block', 'planes.comisionAdministracion')
                    ->join('estados', 'estados_pagos_mandatarios.idEstado', '=', 'estados.idEstado')
                    ->join('mandatos_propiedad', 'estados_pagos_mandatarios.idMandatoPropiedad', '=', 'mandatos_propiedad.idMandatoPropiedad')
                    ->join('planes', 'planes.id', '=', 'mandatos_propiedad.idPlan')
                    ->join('propiedades', 'mandatos_propiedad.idPropiedad', '=', 'propiedades.id')
                    ->join('users', 'mandatos_propiedad.idPropietario', '=', 'users.id')
                    ->leftjoin('usuarios_cuentas_bancarias', 'mandatos_propiedad.idUsuarioCuentaBancaria', '=', 'usuarios_cuentas_bancarias.idUsuarioCuentaBancaria')
                    ->leftjoin('bancos', 'usuarios_cuentas_bancarias.idBanco', '=', 'bancos.idBanco')
                    ->leftjoin('contratos_arriendos', 'mandatos_propiedad.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
                    ->where('estados_pagos_mandatarios.idEstado', '=', 68)
                    ->whereMonth('estados_pagos_mandatarios.fechaDePago', '=', $this->mes)
                    ->whereYear('estados_pagos_mandatarios.fechaDePago', '=', $this->anio)
                    ->orderBy('mandatos_propiedad.nombrePropietario', 'ASC')
                    ->get();
        }
        $todosLosDatos = Array();
        $i = 0;
        foreach ($estadosPagosMandatarios as $estadoPagoMandatario) 
        {
            $nuevoDato = new \stdClass();
            $nuevoDato->nombrePropiedad = $estadoPagoMandatario->nombrePropiedad;
            $nuevoDato->direccion = $estadoPagoMandatario->direccion. ' '. $estadoPagoMandatario->numero. ' - '. $estadoPagoMandatario->block;
            $nuevoDato->nombrePropietario = $estadoPagoMandatario->nombrePropietario;
            $nuevoDato->apellidoPropietario = $estadoPagoMandatario->apellidoPropietario;
            $nuevoDato->rutPropietario = $estadoPagoMandatario->rutPropietario;
            $nuevoDato->nombreArrendatario = $estadoPagoMandatario->nombreArrendatario;
            $nuevoDato->apellidoArrendatario = $estadoPagoMandatario->apellidoArrendatario;
            $nuevoDato->rutArrendatario = $estadoPagoMandatario->rutArrendatario;
            $nuevoDato->montoAPagar = $estadoPagoMandatario->montoAPagar;
            $nuevoDato->cargosAbonos = $estadoPagoMandatario->cargosAbonos;
            $nuevoDato->montoPagado = $estadoPagoMandatario->montoPagado;
            $nuevoDato->pago = "";
            $nuevoDato->fechaCreado = "";
            $nuevoDato->metodoPago = "";
            $nuevoDato->garantia = $estadoPagoMandatario->garantia;
            $nuevoDato->comisionCorretaje = $estadoPagoMandatario->comisionCorretaje;
            $nuevoDato->montoComision = $estadoPagoMandatario->montoComision;
            $nuevoDato->comisionAdministracion = $estadoPagoMandatario->comisionAdministracion;
            $nuevoDato->montoDeuda = $estadoPagoMandatario->montoDeuda;
            $nuevoDato->saldoArrastre = $estadoPagoMandatario->saldoArrastre;
            $nuevoDato->montoALiquidarPropietario = $estadoPagoMandatario->montoALiquidarPropietario;
            $nuevoDato->nombreEstado = $estadoPagoMandatario->nombreEstado;
            $nuevoDato->nombreBanco = $estadoPagoMandatario->nombreBanco;
            $nuevoDato->numeroCuenta = $estadoPagoMandatario->numeroCuenta;
            $nuevoDato->observaciones = $estadoPagoMandatario->observaciones;
            $nuevoDato->correo = $estadoPagoMandatario->email;
            $nuevoDato->fechaLiquidado = $estadoPagoMandatario->fechaLiquidado;
            $todosLosDatos[$i] = $nuevoDato;
            $i++;

            $estadosPagos = EstadoPago::select('pagos.montoPago', 'pagos.created_at as fechaEnQuePago', 'metodos_pagos.nombreMetodoPago')
                ->join('pagos', 'pagos.tokenEstadoPago', '=', 'estados_pagos.token')
                ->leftjoin('metodos_pagos', 'pagos.idMetodoPago', '=', 'metodos_pagos.idMetodosPagos')
                ->where('estados_pagos.idEstadoPago', '=', $estadoPagoMandatario->idEstadoPago)
                ->get();
            if($estadosPagos)
            {
                foreach($estadosPagos as $estadoPagoArrendatario)
                {
                    $nuevosDato = new \stdClass();
                    $nuevosDato->nombrePropiedad = "";
                    $nuevosDato->direccion = "";
                    $nuevosDato->nombrePropietario = "";
                    $nuevosDato->apellidoPropietario = "";
                    $nuevosDato->rutPropietario = "";
                    $nuevosDato->nombreArrendatario = "";
                    $nuevosDato->apellidoArrendatario = "";
                    $nuevosDato->rutArrendatario = "";
                    $nuevosDato->montoAPagar = "";
                    $nuevosDato->cargosAbonos = "";
                    $nuevosDato->montoPagado = "";
                    $nuevosDato->pago = $estadoPagoArrendatario->montoPago;
                    $nuevosDato->fechaCreado = $estadoPagoArrendatario->fechaEnQuePago;
                    $nuevosDato->metodoPago = $estadoPagoArrendatario->nombreMetodoPago;
                    $nuevosDato->garantia = "";
                    $nuevosDato->comisionCorretaje = "";
                    $nuevosDato->montoComision = "";
                    $nuevosDato->comisionAdministracion = "";
                    $nuevosDato->montoDeuda = "";
                    $nuevosDato->saldoArrastre = "";
                    $nuevosDato->montoALiquidarPropietario = "";
                    $nuevosDato->nombreEstado = "";
                    $nuevosDato->nombreBanco = "";
                    $nuevosDato->numeroCuenta = "";
                    $nuevosDato->observaciones = "";
                    $nuevosDato->correo = "";
                    $nuevosDato->fechaLiquidado = "";
                    $todosLosDatos[$i] = $nuevosDato;
                    $i++;
                }
            }
        }
        $sheet->getStyle('A1:X1')->applyFromArray(
            [
                'borders' => [
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '808080'
                        ]
                    ],
                    'top' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '808080'
                        ]
                    ],
                    'left' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '808080'
                        ]
                    ],
                    'right' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '808080'
                        ]
                    ]
                ],
                'quotePrefix'    => true
            ]
        );
        if($todosLosDatos)
        {
            foreach ($todosLosDatos as $key => $value) 
            {
                if($value->pago)
                {

                }
                else
                {
                    $sheet->getStyle('A'.($key + 2).':X'.($key + 2))->applyFromArray(
                        [
                            'borders' => [
                                'bottom' => [
                                    'borderStyle' => Border::BORDER_MEDIUM,
                                    'color' => [
                                        'rgb' => '808080'
                                    ]
                                ],
                                'top' => [
                                    'borderStyle' => Border::BORDER_MEDIUM,
                                    'color' => [
                                        'rgb' => '808080'
                                    ]
                                ],
                                'left' => [
                                    'borderStyle' => Border::BORDER_MEDIUM,
                                    'color' => [
                                        'rgb' => '808080'
                                    ]
                                ],
                                'right' => [
                                    'borderStyle' => Border::BORDER_MEDIUM,
                                    'color' => [
                                        'rgb' => '808080'
                                    ]
                                ]
                            ],
                            'quotePrefix'    => true
                        ]
                    );
                }
            }
        }
        $sheet->getParent()->getActiveSheet()->getProtection()->setSheet(true);
        // lock all cells then unlock the cell
        $sheet->getParent()->getActiveSheet()
            ->getStyle('A1:C1')
            ->getProtection()
            ->setLocked(Protection::PROTECTION_PROTECTED);
        $sheet->getStyle(1)->getFont()->setBold(true);
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->setFreeze('A2');
            },
        ];
    }
    public function view(): View
    {
        if($this->tipo == 1)
        {
            $estadosPagosMandatarios = EstadosPagosMandatarios::select('propiedades.nombrePropiedad', 'mandatos_propiedad.nombrePropietario', 
                    'mandatos_propiedad.apellidoPropietario', 'mandatos_propiedad.rutPropietario', 'mandatos_propiedad.nombreArrendatario', 
                    'mandatos_propiedad.apellidoArrendatario', 'mandatos_propiedad.rutArrendatario', 'estados_pagos_mandatarios.montoAPagar', 
                    'estados_pagos_mandatarios.cargosAbonos', 'estados_pagos_mandatarios.montoPagado', 'estados_pagos_mandatarios.garantia', 
                    'estados_pagos_mandatarios.montoComision',  'estados_pagos_mandatarios.montoDeuda', 'estados_pagos_mandatarios.saldoArrastre', 
                    'estados_pagos_mandatarios.montoALiquidarPropietario', 'estados.nombreEstado','bancos.nombreBanco',
                    DB::raw('CONCAT(usuarios_cuentas_bancarias.numeroCuenta, ", ", bancos.nombreBanco) AS observaciones'), 'users.email', 
                    'estados_pagos_mandatarios.fechaLiquidado' , 'estados_pagos_mandatarios.idEstadoPago', 'estados_pagos_mandatarios.comisionCorretaje',
                    'planes.comisionAdministracion')
                    ->join('estados', 'estados_pagos_mandatarios.idEstado', '=', 'estados.idEstado')
                    ->join('mandatos_propiedad', 'estados_pagos_mandatarios.idMandatoPropiedad', '=', 'mandatos_propiedad.idMandatoPropiedad')
                    ->join('planes', 'planes.id', '=', 'mandatos_propiedad.idPlan')
                    ->join('propiedades', 'mandatos_propiedad.idPropiedad', '=', 'propiedades.id')
                    ->join('users', 'mandatos_propiedad.idPropietario', '=', 'users.id')
                    ->leftjoin('usuarios_cuentas_bancarias', 'mandatos_propiedad.idUsuarioCuentaBancaria', '=', 'usuarios_cuentas_bancarias.idUsuarioCuentaBancaria')
                    ->leftjoin('bancos', 'usuarios_cuentas_bancarias.idBanco', '=', 'bancos.idBanco')
                    //nueva linea
                    ->leftjoin('estados_pagos', 'estados_pagos_mandatarios.idEstadoPago', '=', 'estados_pagos.idEstadoPago')
                    ->leftjoin('pagos', 'estados_pagos.idEstadoPago', '=', 'pagos.idEstadoPago')
                    //fin
                    ->leftjoin('contratos_arriendos', 'mandatos_propiedad.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
                    ->whereIn('estados_pagos_mandatarios.idEstado', [67, 69])
                    ->whereMonth('estados_pagos_mandatarios.fechaDePago', '=', $this->mes)
                    ->whereYear('estados_pagos_mandatarios.fechaDePago', '=', $this->anio)
                    ->orderBy('mandatos_propiedad.nombrePropietario', 'ASC')
                    ->get();
        }
        else
        {
            $estadosPagosMandatarios = EstadosPagosMandatarios::select('propiedades.nombrePropiedad', 'mandatos_propiedad.nombrePropietario', 
                    'mandatos_propiedad.apellidoPropietario', 'mandatos_propiedad.rutPropietario', 'mandatos_propiedad.nombreArrendatario', 
                    'mandatos_propiedad.apellidoArrendatario', 'mandatos_propiedad.rutArrendatario', 'estados_pagos_mandatarios.montoAPagar', 
                    'estados_pagos_mandatarios.cargosAbonos', 'estados_pagos_mandatarios.montoPagado', 'estados_pagos_mandatarios.garantia', 
                    'estados_pagos_mandatarios.montoComision',  'estados_pagos_mandatarios.montoDeuda', 'estados_pagos_mandatarios.saldoArrastre', 
                    'estados_pagos_mandatarios.montoALiquidarPropietario', 'estados.nombreEstado','bancos.nombreBanco',
                    DB::raw('CONCAT(usuarios_cuentas_bancarias.numeroCuenta, ", ", bancos.nombreBanco) AS observaciones'), 'users.email', 
                    'estados_pagos_mandatarios.fechaLiquidado' , 'estados_pagos_mandatarios.idEstadoPago', 'estados_pagos_mandatarios.comisionCorretaje',
                    'propiedades.direccion', 'propiedades.numero', 'propiedades.block', 'planes.comisionAdministracion')
                    ->join('estados', 'estados_pagos_mandatarios.idEstado', '=', 'estados.idEstado')
                    ->join('mandatos_propiedad', 'estados_pagos_mandatarios.idMandatoPropiedad', '=', 'mandatos_propiedad.idMandatoPropiedad')
                    ->join('planes', 'planes.id', '=', 'mandatos_propiedad.idPlan')
                    ->join('propiedades', 'mandatos_propiedad.idPropiedad', '=', 'propiedades.id')
                    ->join('users', 'mandatos_propiedad.idPropietario', '=', 'users.id')
                    ->leftjoin('usuarios_cuentas_bancarias', 'mandatos_propiedad.idUsuarioCuentaBancaria', '=', 'usuarios_cuentas_bancarias.idUsuarioCuentaBancaria')
                    ->leftjoin('bancos', 'usuarios_cuentas_bancarias.idBanco', '=', 'bancos.idBanco')
                    ->leftjoin('contratos_arriendos', 'mandatos_propiedad.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
                    ->where('estados_pagos_mandatarios.idEstado', '=', 68)
                    ->whereMonth('estados_pagos_mandatarios.fechaDePago', '=', $this->mes)
                    ->whereYear('estados_pagos_mandatarios.fechaDePago', '=', $this->anio)
                    ->orderBy('mandatos_propiedad.nombrePropietario', 'ASC')
                    ->get();
        }
        $todosLosDatos = Array();
        $i = 0;
        foreach ($estadosPagosMandatarios as $estadoPagoMandatario) 
        {
            $nuevoDato = new \stdClass();
            $nuevoDato->nombrePropiedad = $estadoPagoMandatario->nombrePropiedad;
            $nuevoDato->direccion = $estadoPagoMandatario->direccion. ' '. $estadoPagoMandatario->numero. ' - '. $estadoPagoMandatario->block;
            $nuevoDato->nombrePropietario = $estadoPagoMandatario->nombrePropietario;
            $nuevoDato->apellidoPropietario = $estadoPagoMandatario->apellidoPropietario;
            $nuevoDato->rutPropietario = $estadoPagoMandatario->rutPropietario;
            $nuevoDato->nombreArrendatario = $estadoPagoMandatario->nombreArrendatario;
            $nuevoDato->apellidoArrendatario = $estadoPagoMandatario->apellidoArrendatario;
            $nuevoDato->rutArrendatario = $estadoPagoMandatario->rutArrendatario;
            $nuevoDato->montoAPagar = $estadoPagoMandatario->montoAPagar;
            $nuevoDato->cargosAbonos = $estadoPagoMandatario->cargosAbonos;
            $nuevoDato->montoPagado = $estadoPagoMandatario->montoPagado;
            $nuevoDato->pago = "";
            $nuevoDato->fechaCreado = "";
            $nuevoDato->metodoPago = "";
            $nuevoDato->garantia = $estadoPagoMandatario->garantia;
            $nuevoDato->comisionCorretaje = $estadoPagoMandatario->comisionCorretaje;
            $nuevoDato->montoComision = $estadoPagoMandatario->montoComision;
            $nuevoDato->comisionAdministracion = $estadoPagoMandatario->comisionAdministracion;
            $nuevoDato->montoDeuda = $estadoPagoMandatario->montoDeuda;
            $nuevoDato->saldoArrastre = $estadoPagoMandatario->saldoArrastre;
            $nuevoDato->montoALiquidarPropietario = $estadoPagoMandatario->montoALiquidarPropietario;
            $nuevoDato->nombreEstado = $estadoPagoMandatario->nombreEstado;
            $nuevoDato->nombreBanco = $estadoPagoMandatario->nombreBanco;
            $nuevoDato->numeroCuenta = $estadoPagoMandatario->numeroCuenta;
            $nuevoDato->observaciones = $estadoPagoMandatario->observaciones;
            $nuevoDato->correo = $estadoPagoMandatario->email;
            $nuevoDato->fechaLiquidado = $estadoPagoMandatario->fechaLiquidado;
            $todosLosDatos[$i] = $nuevoDato;
            $i++;

            $estadosPagos = EstadoPago::select('pagos.montoPago', 'pagos.created_at as fechaEnQuePago', 'metodos_pagos.nombreMetodoPago')
                ->join('pagos', 'pagos.tokenEstadoPago', '=', 'estados_pagos.token')
                ->leftjoin('metodos_pagos', 'pagos.idMetodoPago', '=', 'metodos_pagos.idMetodosPagos')
                ->where('estados_pagos.idEstadoPago', '=', $estadoPagoMandatario->idEstadoPago)
                ->get();
            if($estadosPagos)
            {
                foreach($estadosPagos as $estadoPagoArrendatario)
                {
                    $nuevosDato = new \stdClass();
                    $nuevosDato->nombrePropiedad = "";
                    $nuevosDato->direccion = "";
                    $nuevosDato->nombrePropietario = "";
                    $nuevosDato->apellidoPropietario = "";
                    $nuevosDato->rutPropietario = "";
                    $nuevosDato->nombreArrendatario = "";
                    $nuevosDato->apellidoArrendatario = "";
                    $nuevosDato->rutArrendatario = "";
                    $nuevosDato->montoAPagar = "";
                    $nuevosDato->cargosAbonos = "";
                    $nuevosDato->montoPagado = "";
                    $nuevosDato->pago = $estadoPagoArrendatario->montoPago;
                    $nuevosDato->fechaCreado = $estadoPagoArrendatario->fechaEnQuePago;
                    $nuevosDato->metodoPago = $estadoPagoArrendatario->nombreMetodoPago;
                    $nuevosDato->garantia = "";
                    $nuevosDato->comisionCorretaje = "";
                    $nuevosDato->montoComision = "";
                    $nuevosDato->comisionAdministracion = "";
                    $nuevosDato->montoDeuda = "";
                    $nuevosDato->saldoArrastre = "";
                    $nuevosDato->montoALiquidarPropietario = "";
                    $nuevosDato->nombreEstado = "";
                    $nuevosDato->nombreBanco = "";
                    $nuevosDato->numeroCuenta = "";
                    $nuevosDato->observaciones = "";
                    $nuevosDato->correo = "";
                    $nuevosDato->fechaLiquidado = "";
                    $todosLosDatos[$i] = $nuevosDato;
                    $i++;
                }
            }
        }

        return view('back-office.mandatos.excelLiquidacionInversionista', [
            'todosLosDatos' => $todosLosDatos
        ]);
    }
}
