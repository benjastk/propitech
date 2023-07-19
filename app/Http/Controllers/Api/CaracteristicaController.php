<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CaracteristicaPlan;
use Session;
use DB;
class CaracteristicaController extends Controller
{
    public function storeCaracteristica(Request $request)
    {
        try{
            DB::beginTransaction();
            $caracteristicaPlan = new CaracteristicaPlan();
            $caracteristicaPlan->nombreCaracteristica = $request->nombre;
            $caracteristicaPlan->orden = $request->orden;
            $caracteristicaPlan->save();
            DB::commit();
            $caracteristicas = CaracteristicaPlan::get();
            return response()->json(['status' => true, 'message' => 'OK', 'caracteristicas' => $caracteristicas], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        } catch (DecryptException $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
    public function destroyCaracteristica(Request $request)
    {
        try{
            DB::beginTransaction();
            $caracteristicaPlan = CaracteristicaPlan::where('idCaracteristica', $request->id)->first();
            $caracteristicaPlan->delete();
            DB::commit();
            $caracteristicas = CaracteristicaPlan::get();
            return response()->json(['status' => true, 'message' => 'OK', 'caracteristicas' => $caracteristicas], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        } catch (DecryptException $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
