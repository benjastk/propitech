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
        $schedule->call('App\Http\Controllers\EstadoPagoController@cambiarAMoroso')->dailyAt('1:00');
        $schedule->call('App\Http\Controllers\EstadoPagoController@cambiarAVencido')->dailyAt('2:00');
        //$schedule->call('App\Http\Controllers\EstadoPagoController@agregarPorcentajeAMorosos')->dailyAt('3:00');
        $schedule->call('App\Http\Controllers\AlertaController@recordarPagoArrendatariosMensual')->dailyAt('17:55');
        //$schedule->call('App\Http\Controllers\AlertaController@pruebaMail')->dailyAt('13:45');
    }

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
