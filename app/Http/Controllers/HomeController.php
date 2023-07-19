<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
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
        $user = Auth::user();
        return view('back-office.home', compact('user'));
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
