<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use Carbon\Carbon;
use App\Propiedad;
class HomeController2 extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        $hora = Carbon::now();

        return view('back-office-users.home', compact('hora', 'user'));
    }
}
