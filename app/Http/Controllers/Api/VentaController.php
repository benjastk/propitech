<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Venta;
class VentaController extends Controller
{
    public function indexVentas()
    {
        try
        {
            $entrantes = Venta::select('ventas_propiedades.*', 'users.name', 'users.apellido', 'users.avatarImg')
            ->leftjoin('users', 'users.id', '=', 'ventas_propiedades.idUsuarioVendedor')
            ->get();
            return response()->json($entrantes);
        } catch (QueryException $e) {
            return false;
        } catch (ModelNotFoundException $e) {
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
    public function cambiarVenta(Request $request)
    {
        try
        {
            $venta = Venta::where('idVenta', $request->id)->firstOrFail();
            if($request->estado == 'activas')
            {
                $venta->idEstado = 58;
            }
            elseif($request->estado == 'proceso')
            {
                $venta->idEstado = 59;
            }
            elseif($request->estado == 'finalizadas')
            {
                $venta->idEstado = 60;
            }
            $venta->save();
            return response()->json(true);
        } catch (QueryException $e) {
            return response()->json($e);
        } catch (ModelNotFoundException $e) {
            return response()->json($e);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
