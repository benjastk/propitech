<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use App\Propiedad;
use App\ContratoArriendo;
use App\FormularioContacto;
use App\MandatoAdministracion;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $leadsContactos = FormularioContacto::select(DB::raw('count(*) as cantidadLeads'), DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') as fecha"))
        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
        ->orderBy('created_at', 'asc')
        ->get();
        $user = Auth::user();
        $propiedadesVenta = Propiedad::where('idTipoComercial', 1)->where('idEstado', 42)->count();
        $propiedadesArriendo = Propiedad::where('idTipoComercial', 2)->where('idEstado', 42)->count();
        $contratosArriendos = ContratoArriendo::where('idEstado', 61)->count();
        $mandatosAdministracion = MandatoAdministracion::where('idEstadoMandato', 61)->count();
        return view('back-office.home', compact('user', 'leadsContactos', 'propiedadesVenta', 'propiedadesArriendo', 'contratosArriendos', 
        'mandatosAdministracion'));
    }
    public function users()
    {
        $user = Auth::user();
        $users = User::join('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->join('roles', 'roles.id', '=', 'rol_usuario.id_rol')
        ->get();
        return view('back-office.users', compact('user', 'users'));
    }
}
