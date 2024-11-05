<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $mes = date("m");
        $anio = date("Y");
        $schedule->call('App\Http\Controllers\EstadoPagoController@cambiarAMoroso')->dailyAt('00:30');
        $schedule->call('App\Http\Controllers\EstadoPagoController@cambiarAVencido')->dailyAt('1:00');
        $schedule->call('App\Http\Controllers\EstadoPagoController@agregarPorcentajeAMorosos')->dailyAt('1:30');
        $schedule->call('App\Http\Controllers\AlertaController@recordarPagoArrendatariosMensual')->dailyAt('10:00');
        $schedule->call('App\Http\Controllers\AlertaController@ultimoDiaParaPagar')->dailyAt('11:40');
        $schedule->call('App\Http\Controllers\Api\BuyDepaIntegracionController@sincronizeProperties')->dailyAt('09:00');
        //$schedule->call('App\Http\Controllers\Api\IntegracionYapoController@refreshToken')->everyFourHours();
        $schedule->call('App\Http\Controllers\Api\IntegracionPortalController@refreshToken')->everyFourHours();
        //$schedule->call('App\Http\Controllers\AlertaController@pruebaMail')->dailyAt('13:45');
    }
    Hola! Hablas con Benjamin de Propitech, el departamento está disponible y este se encuentra en María Rosas Velázquez 65 en estación central, se ubica en el piso 5 y tiene 2 habitaciónes, 1 baño. 
Los gastos comunes son muy bajos y tiene muy buena conectividad ya que se encuentra a pasos del metro las rejas.
Coménteme si esta interesado y te envió los requisitos que debes enviar para evaluarte y generar una visita
Tambien cuentame si tienes alguna duda o puedes contactarnos al Whatsapp +56927429764

Hola! Hablas con Benjamin de Propitech, el departamento está disponible y este se encuentra en Santa Rosa 5741, se ubica en el piso 4 y tiene 3 habitaciónes, 1 baño. 
Los gastos comunes son muy bajos y tiene muy buena conectividad ya que se encuentra en plena Avenida Santa Rosa.
el valor del departamento es de $320.000 y los gastos comunes en $45.000 aprox

Coménteme si esta interesada y te envió los requisitos que debes enviar para evaluarte y generar una visita
Tambien cuentame si tienes alguna duda o puedes contactarnos al Whatsapp +56927429764
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

- 