<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IntegracionPortalController extends Controller
{
    public function auth(Request $request)
    {
        return response()->json($request);
    }
}
