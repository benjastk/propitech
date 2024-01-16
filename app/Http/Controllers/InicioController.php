<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Foto;
use Session;
use App\Propiedad;
use App\Region;
use App\Pais;
use App\Comuna;
use App\Noticia;
use App\Proyecto;
use App\Provincia;
use App\Tipologia;
use App\EstadoPago;
use App\FotoCercana;
use App\FotoProyecto;
use App\RentaMensual;
use App\TipoPropiedad;
use App\TipoComercial;
use App\ParametroGeneral;
use App\ReservaPropiedad;
use App\PlanAdministracion;
use App\CaracteristicaPlan;
use App\CaracteristicaPlanAsignada;
use App\CaracteristicasPorProyectos;
use App\CaracteristicasPorPropiedades;

class InicioController extends Controller
{
    public function comingSoon()
    {
        return view('front-end.mantenimiento');
    }
    public function index()
    {
        $propiedadesEnArriendo = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
        'region.nombre as nombreRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->where('propiedades.idEstado', 42)
        ->where('propiedades.idTipoComercial', 2) //Arriendo
        ->get();
        $propiedadesEnVenta = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
        'region.nombre as nombreRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->where('propiedades.idEstado', 42)
        ->where('propiedades.idTipoComercial', 1) //Venta
        ->get();
        $propiedadesDestacadas = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
        'region.nombre as nombreRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->where('propiedades.idEstado', 42)
        ->where('idDestacado', 1) //Venta
        ->get();
        $habitaciones = Propiedad::select('propiedades.habitacion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->where('propiedades.idEstado', 42)
        ->groupBy('propiedades.habitacion')
        ->get();
        $comunas = Comuna::get();
        $paises = Pais::get();
        $regiones = Region::get();
        $provincias = Provincia::get();

        $noticias = Noticia::whereNull('deleteOf')
        ->orderBy('fechaPublicacion', 'desc')->get();

        $planes = PlanAdministracion::where('activo', 1)
        ->where('eliminado', 0)
        ->orderBy('comisionAdministracion', 'asc')
        ->get();
        if($planes)
        {
            foreach ($planes as $plan) 
            {
                $caracteristicas = CaracteristicaPlanAsignada::select('idCaracteristicaPlan')->where('idPlan', $plan->id)->get();
                $plan->caracteristicas = $caracteristicas;
                $noContemplados= [];
                if($caracteristicas)
                {
                    foreach ($caracteristicas as $carac) 
                    {
                        array_push($noContemplados, $carac->idCaracteristicaPlan);
                    }
                }
                $noCaracteristicasPlanes = CaracteristicaPlan::whereNotIn('idCaracteristica', $noContemplados)->get();
                $plan->noCaracteristicas = $noCaracteristicasPlanes;
            }
        }
        $caracteristicasPlanes = CaracteristicaPlan::get();
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        $isCyber = ParametroGeneral::where('parametroGeneral', 'CYBER')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
        return view('front-end.home', compact('propiedadesEnArriendo', 'propiedadesEnVenta', 'propiedadesDestacadas', 'comunas', 'paises', 
        'regiones', 'provincias', 'habitaciones', 'noticias', 'planes', 'caracteristicasPlanes',
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 'isCyber', 'invierteAqui'));
    }
    public function list(Request $request)
    {
        $habitaciones = Propiedad::select('propiedades.habitacion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->where('propiedades.idEstado', 42)
        ->groupBy('propiedades.habitacion')
        ->get();
        $comunas = Comuna::get();
        $paises = Pais::get();
        $regiones = Region::get();
        $provincias = Provincia::get();
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
        if($request->tipoVenta == 1)
        {
            $propiedadesEnVenta1 = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
            'region.nombre as nombreRegion')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->where('propiedades.idEstado', 42)
            ->where('propiedades.idTipoComercial', 1); //Venta
            if($request->region > 0)
            {
                $propiedadesEnVenta1->where('propiedades.idRegion', $request->region);
            }
            if($request->comuna > 0)
            {
                $propiedadesEnVenta1->where('propiedades.idComuna', $request->comuna);
            }
            
            //coordenada central
            if($request->region)
            {
                $region1 = Region::where('id', $request->region)->first();
                $coordenada = '['. $region1->longitudRegion.', '. $region1->latitudRegion.']';
            }
            else
            {
                $coordenada = '[-70.64827, -33.45694]';
            }   
            if($request->comuna)
            {
                $comuna1 = Comuna::where('id', $request->comuna)->first();
                $coordenada = '['. $comuna1->longitudComuna.', '. $comuna1->latitudComuna.']';
            }
            else
            {
                $coordenada = '[-70.64827, -33.45694]';
            }   
            $propiedadesEnVenta = $propiedadesEnVenta1->get();
            return view('front-end.mapa-catalogo-venta', compact('propiedadesEnVenta','comunas', 'paises', 'regiones', 'provincias', 'habitaciones',
                'telefonoWhatsapp', 'coordenada', 'invierteAqui'));
        }
        else if($request->tipoVenta == 2)
        {
            $propiedadesEnArriendo1 = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
            'region.nombre as nombreRegion')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->where('propiedades.idEstado', 42)
            ->where('propiedades.idTipoComercial', 2); //Arriendo
            if($request->region > 0)
            {
                $propiedadesEnArriendo1->where('propiedades.idRegion', $request->region);
            }
            if($request->comuna > 0)
            {
                $propiedadesEnArriendo1->where('propiedades.idComuna', $request->comuna);
            }
            $propiedadesEnArriendo = $propiedadesEnArriendo1->get();
            //coordenada central
            if($request->region)
            {
                $region1 = Region::where('id', $request->region)->first();
                $coordenada = '['. $region1->longitudRegion.', '. $region1->latitudRegion.']';
            }
            else
            {
                $coordenada = '[-70.64827, -33.45694]';
            }  
            if($request->comuna)
            {
                $comuna1 = Comuna::where('id', $request->comuna)->first();
                $coordenada = '['. $comuna1->longitudComuna.', '. $comuna1->latitudComuna.']';
            }
            else
            {
                $coordenada = '[-70.64827, -33.45694]';
            }   
            return view('front-end.mapa-catalogo-arriendo', compact('propiedadesEnArriendo','comunas', 'paises', 'regiones', 'provincias', 
                'habitaciones', 'telefonoWhatsapp', 'coordenada', 'invierteAqui'));
        }
        else
        {
            $propiedadesEnArriendo1 = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
            'region.nombre as nombreRegion')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->where('propiedades.idEstado', 42)
            ->where('propiedades.idTipoComercial', 2); //Arriendo
            if($request->region > 0)
            {
                $propiedadesEnArriendo1->where('propiedades.idRegion', $request->region);
            }
            if($request->comuna > 0)
            {
                $propiedadesEnArriendo1->where('propiedades.idComuna', $request->comuna);
            }
            //coordenada central
            if($request->region)
            {
                $region1 = Region::where('id', $request->region)->first();
                $coordenada = '['. $region1->longitudRegion.', '. $region1->latitudRegion.']';
            }
            else
            {
                $coordenada = '[-70.64827, -33.45694]';
            }
            if($request->comuna)
            {
                $comuna1 = Comuna::where('id', $request->comuna)->first();
                $coordenada = '['. $comuna1->longitudComuna.', '. $comuna1->latitudComuna.']';
            }
            else
            {
                $coordenada = '[-70.64827, -33.45694]';
            }
            $propiedadesEnArriendo = $propiedadesEnArriendo1->get();
            return view('front-end.mapa-catalogo-arriendo', compact('propiedadesEnArriendo','comunas', 'paises', 'regiones', 'provincias', 
                'habitaciones', 'telefonoWhatsapp', 'coordenada', 'invierteAqui'));
        }
    }
    public function mapaCatalogoPropiedades(Request $request)
    {
        $habitaciones = Propiedad::select('propiedades.habitacion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->where('propiedades.idEstado', 42)
        ->groupBy('propiedades.habitacion')
        ->get();
        $comunas = Comuna::get();
        $paises = Pais::get();
        $regiones = Region::get();
        $provincias = Provincia::get();
        $propiedadesEnArriendo = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
        'region.nombre as nombreRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->where('propiedades.idEstado', 42)
        ->where('propiedades.idTipoComercial', 2)
        ->get(); //Arriendo

        if($request->tipoPropiedad)
        {
            $propiedadesEnArriendo = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
            'region.nombre as nombreRegion')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->where('propiedades.idEstado', 42)
            ->where('propiedades.idTipoComercial', 2)
            ->where('idTipoPropiedad', $request->tipoPropiedad)
            ->get();
        }
        else
        {
            $propiedadesEnArriendo = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
            'region.nombre as nombreRegion')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->where('propiedades.idEstado', 42)
            ->where('propiedades.idTipoComercial', 2)
            ->get();
        }
        //coordenada central
        if($request->region)
        {
            $region = Region::where('id', $request->region)->first();
            $coordenada = '['. $region->longitudRegion.', '. $region->latitudRegion.']';
        }
        else if($request->comuna)
        {
            $comuna = Comuna::where('id', $request->comuna)->first();
            $coordenada = '['. $comuna->longitudComuna.', '. $comuna->latitudComuna.']';
        }
        else
        {
            $coordenada = '[-70.64827, -33.45694]';
        }   
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        return view('front-end.mapa-catalogo-arriendo', compact('propiedadesEnArriendo','comunas', 'paises', 'regiones', 'provincias', 'habitaciones',
        'telefonoWhatsapp', 'coordenada', 'invierteAqui'));
    }
    public function mapaCatalogoPropiedadesVenta(Request $request)
    {
        $habitaciones = Propiedad::select('propiedades.habitacion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->where('propiedades.idEstado', 42)
        ->groupBy('propiedades.habitacion')
        ->get();
        $comunas = Comuna::get();
        $paises = Pais::get();
        $regiones = Region::get();
        $provincias = Provincia::get();
        if($request->tipoPropiedad)
        {
            $propiedadesEnVenta = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
            'region.nombre as nombreRegion')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->where('propiedades.idEstado', 42)
            ->where('propiedades.idTipoComercial', 1)
            ->where('idTipoPropiedad', $request->tipoPropiedad)
            ->get(); //venta
        }
        else
        {
            $propiedadesEnVenta = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
            'region.nombre as nombreRegion')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->where('propiedades.idEstado', 42)
            ->where('propiedades.idTipoComercial', 1)
            ->get(); //venta
        }
        //coordenada central
        if($request->region)
        {
            $region = Region::where('id', $request->region)->first();
            $coordenada = '['. $region->longitudRegion.', '. $region->latitudRegion.']';
        }
        else if($request->comuna)
        {
            $comuna = Comuna::where('id', $request->comuna)->first();
            $coordenada = '['. $comuna->longitudComuna.', '. $comuna->latitudComuna.']';
        }
        else
        {
            $coordenada = '[-70.64827, -33.45694]';
        }   
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
        return view('front-end.mapa-catalogo-venta', compact('propiedadesEnVenta','comunas', 'paises', 'regiones', 'provincias', 'habitaciones', 
        'telefonoWhatsapp', 'coordenada', 'invierteAqui'));
    }
    public function singleProperty($id)
    {
        $propiedad = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
        'region.nombre as nombreRegion', 'tipos_propiedades.nombreTipoPropiedad', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'users.name',
        'users.email', 'users.telefono', 'users.avatarImg')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('tipos_propiedades', 'propiedades.idTipoPropiedad', '=', 'tipos_propiedades.idTipoPropiedad')
        ->join('niveles_uso_propiedad', 'propiedades.idNivelUsoPropiedad', '=', 'niveles_uso_propiedad.idNivelUsoPropiedad')
        ->leftjoin('users', 'users.id', '=', 'propiedades.idUsuarioExpertoVendedor')
        ->where('propiedades.id', $id)
        ->first();

        $fotos = Foto::where('idPropiedad', $id)->get();
        if($fotos)
        {
            $propiedad->fotos = $fotos;
        }
        else
        {
            $propiedad->fotos = [];
        }

        $propiedadesDestacadas1 = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
        'region.nombre as nombreRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->where('propiedades.idEstado', 42)
        ->where('propiedades.idTipoComercial', $propiedad->idTipoComercial)
        ->where('propiedades.id', '!=', $propiedad->id)
        ->get();

        $amenidades = CaracteristicasPorPropiedades::select('caracteristicas_propiedades.*')
        ->join('propiedades', 'propiedades.id', '=', 'caracteristicas_por_propiedades.idPropiedad')
        ->join('caracteristicas_propiedades', 'caracteristicas_propiedades.idCaracteristicaPropiedad', '=', 'caracteristicas_por_propiedades.idCaracteristicaPropiedad')
        ->where('caracteristicas_por_propiedades.idPropiedad', $propiedad->id)
        ->get();

        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
        return view('front-end.single-property', compact('propiedad', 'amenidades', 'propiedadesDestacadas1',
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 'invierteAqui'));
    }
    public function singleBlog($urlNoticia)
    {
        $noticia = Noticia::select('noticias.*', 'users.name', 'users.apellido', 'users.avatarImg', 'roles.nombre')
        ->leftjoin('users', 'noticias.idUsuario', '=', 'users.id')
        ->leftjoin('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->leftjoin('roles', 'roles.id', '=', 'rol_usuario.id_rol')
        ->where('urlNoticia', $urlNoticia)
        ->first();
        $noticias = Noticia::where('urlNoticia', '!=', $urlNoticia)
        ->whereNull('deleteOf')
        ->orderBy('fechaPublicacion', 'desc')
        ->get();

        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
        return view('front-end.blog', compact('noticia', 'noticias',
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 'invierteAqui'));
    }
    public function servicios()
    {
        $planes = PlanAdministracion::where('activo', 1)
        ->where('eliminado', 0)
        ->orderBy('comisionAdministracion', 'asc')
        ->get();
        if($planes)
        {
            foreach ($planes as $plan) 
            {
                $caracteristicas = CaracteristicaPlanAsignada::select('idCaracteristicaPlan')->where('idPlan', $plan->id)->get();
                $plan->caracteristicas = $caracteristicas;
                $noContemplados= [];
                if($caracteristicas)
                {
                    foreach ($caracteristicas as $carac) 
                    {
                        array_push($noContemplados, $carac->idCaracteristicaPlan);
                    }
                }
                $noCaracteristicasPlanes = CaracteristicaPlan::whereNotIn('idCaracteristica', $noContemplados)->get();
                $plan->noCaracteristicas = $noCaracteristicasPlanes;
            }
        }
        $caracteristicasPlanes = CaracteristicaPlan::get();

        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
        return view('front-end.servicios', compact('planes', 'caracteristicasPlanes',
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 'invierteAqui'));
    }
    public function nosotros()
    {
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
        return view('front-end.nosotros', compact('telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 'invierteAqui'));
    }
    public function preguntasFrecuentes()
    {
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
        return view('front-end.preguntasFrecuentes', compact('telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 'invierteAqui'));
    }
    public function terminosYCondiciones()
    {
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
        return view('front-end.terminosYCondiciones', compact('telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 'invierteAqui'));
    }
    public function publicaTuPropiedad()
    {
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();$telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();

        $tiposPropiedades = TipoPropiedad::get();
        $tiposComerciales = TipoComercial::get();
        return view('front-end.publica-tu-propiedad', compact('tiposPropiedades', 'tiposComerciales', 
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 'invierteAqui'));
    }
    public function trabajaConNosotros()
    {
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();

        $telefonoContacto = ParametroGeneral::where('parametroGeneral', 'TELEFONO CONTACTO')->first();
        $telefonoContacto2 = ParametroGeneral::where('parametroGeneral', 'TELEFONO CONTACTO 2')->first();
        $correoContacto = ParametroGeneral::where('parametroGeneral', 'CORREO CONTACTO')->first();
        $horarioSemana = ParametroGeneral::where('parametroGeneral', 'HORARIO SEMANA')->first();
        $horarioFinDeSemana = ParametroGeneral::where('parametroGeneral', 'HORARIO FIN DE SEMANA')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();

        $tiposPropiedades = TipoPropiedad::get();
        $tiposComerciales = TipoComercial::get();
        return view('front-end.trabaja-con-nosotros', compact('tiposPropiedades', 'tiposComerciales', 
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram',
        'telefonoContacto', 'telefonoContacto2', 'correoContacto', 'horarioSemana', 'horarioFinDeSemana', 'invierteAqui'));
    }
    public function pagoOnline(Request $request)
    {
        if($request->rut)
        {
            $estadoPago = EstadoPago::select('estados_pagos.*', 'users.rut')
            ->join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
            ->join('users', 'users.id', '=', 'contratos_arriendos.idUsuarioArrendatario')
            ->where('users.rut', $request->rut)
            ->where('contratos_arriendos.idEstado', 61)
            ->whereIn('estados_pagos.idEstado', [ 47, 49, 50])
            ->orderBy('estados_pagos.fechaVencimiento', 'asc')
            ->first();
            $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
            $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
            $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
            $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
            $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
            $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
            $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
            $rut = $request->rut;
            return view('front-end.pago-online', compact('estadoPago', 'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 
            'rut', 'invierteAqui'));
        }
        else
        {
            $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
            $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
            $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
            $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
            $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
            $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
            $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
            $rut = '';
            $estadoPago = '';
        }
        return view('front-end.pago-online', compact('estadoPago', 'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 
        'rut', 'invierteAqui'));
    }
    public function pagarOnline(Request $request)
    {
        Session::put('idEstadoPagoOtrosPagos', '');
        Session::put('tokenOtrosPagos', '');
        if($request->rut)
        {
            $estadoPago = EstadoPago::select('estados_pagos.*', 'users.rut', 'users.idTipoRut')
            ->join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
            ->join('users', 'users.id', '=', 'contratos_arriendos.idUsuarioArrendatario')
            ->where('users.rut', $request->rut)
            ->where('contratos_arriendos.idEstado', 61)
            ->whereIn('estados_pagos.idEstado', [ 47, 49, 50])
            ->orderBy('estados_pagos.fechaVencimiento', 'asc')
            ->first();
            $convenio = getenv("OTROS_PAGOS_COVENIO");
            if($estadoPago)
            {
                Session::put('idEstadoPagoOtrosPagos', $estadoPago->idEstadoPago);
                Session::put('tokenOtrosPagos', $estadoPago->token);
                if($estadoPago->idTipoRut == 2)
                {
                    $tipoRut = '07';
                }
                else
                {
                    $tipoRut = '01';
                }
                return redirect()->to('https://otrospagos.com/publico/portal/enlace?id='.$convenio.'&idcli='.$estadoPago->rut.'&tiidc='.$tipoRut.'');
            }
            else
            {
                $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
                $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
                $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
                $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
                $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
                $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
                $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
                $rut = '';
                $estadoPago = '';
                return view('front-end.pago-online', compact('estadoPago', 'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 
                'rut', 'invierteAqui'));
            }
        }
        else
        {
            $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
            $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
            $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
            $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
            $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
            $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
            $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
            $rut = '';
            $estadoPago = '';
            return view('front-end.pago-online', compact('estadoPago', 'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 
            'rut', 'invierteAqui'));
        }
    }
    public function pagoReservaOnline(Request $request)
    {
        if($request->rut)
        {
            $reserva = ReservaPropiedad::where('reservas_propiedades.rut', $request->rut)
            ->where('eliminado', 0)
            ->where('idEstado', 47)
            ->first();
            $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
            $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
            $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
            $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
            $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
            $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
            $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
            $rut = $request->rut;
            return view('front-end.pago-online-reserva', compact('reserva', 'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 
            'rut', 'invierteAqui'));
        }
        else
        {
            $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
            $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
            $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
            $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
            $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
            $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
            $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
            $rut = '';
            $reserva = '';
        }
        return view('front-end.pago-online-reserva', compact('reserva', 'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 
        'rut', 'invierteAqui'));
    }
    public function pagarReservaOnline(Request $request)
    {
        if($request->rut)
        {
            $reserva = ReservaPropiedad::where('reservas_propiedades.rut', $request->rut)
            ->where('eliminado', 0)
            ->where('idEstado', 47)
            ->first();
            $convenio = getenv("OTROS_PAGOS_COVENIO");
            if($reserva)
            {
                $tipoRut = '01';
                return redirect()->to('https://otrospagos.com/publico/portal/enlace?id='.$convenio.'&idcli='.$reserva->rut.'&tiidc='.$tipoRut.'');
            }
            else
            {
                $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
                $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
                $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
                $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
                $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
                $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
                $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
                $rut = '';
                $reserva = '';
                return view('front-end.pago-online-reserva', compact('reserva', 'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 
                'instagram', 'rut', 'invierteAqui'));
            }
        }
        else
        {
            $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
            $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
            $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
            $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
            $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
            $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
            $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
            $rut = '';
            $estadoPago = '';
            return view('front-end.pago-online-reserva', compact('reserva', 'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 
            'rut', 'invierteAqui'));
        }
    }
    public function proyectosEnVenta(Request $request)
    {
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
        $rentas = RentaMensual::get();
        $proyectos = Proyecto::select('proyectos.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
        'region.nombre as nombreRegion')
        ->join('comuna', 'comuna.id', '=', 'proyectos.idComuna')
        ->join('provincia', 'provincia.id', '=', 'proyectos.idProvincia')
        ->join('region', 'region.id', '=', 'proyectos.idRegion')
        ->get();
        $proyectosDestacados = Proyecto::select('proyectos.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
        'region.nombre as nombreRegion')
        ->join('comuna', 'comuna.id', '=', 'proyectos.idComuna')
        ->join('provincia', 'provincia.id', '=', 'proyectos.idProvincia')
        ->join('region', 'region.id', '=', 'proyectos.idRegion')
        ->where('proyectos.idDestacado', 1)
        ->get();
        //$proyectosDestacados = [];
        return view('front-end.inversiones', compact('telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 
        'rentas', 'proyectosDestacados', 'proyectos', 'invierteAqui'));
    }
    public function singleProyectos($id)
    {
        $proyecto = Proyecto::select('proyectos.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
        'region.nombre as nombreRegion', 'tipos_propiedades.nombreTipoPropiedad', 'users.name', 'users.apellido', 'users.telefono', 'users.email',
        'users.avatarImg')
        ->join('comuna', 'comuna.id', '=', 'proyectos.idComuna')
        ->join('provincia', 'provincia.id', '=', 'proyectos.idProvincia')
        ->join('region', 'region.id', '=', 'proyectos.idRegion')
        ->join('tipos_propiedades', 'proyectos.tipoPropiedad', '=', 'tipos_propiedades.idTipoPropiedad')
        ->leftjoin('users', 'users.id', '=', 'proyectos.creadoPor')
        ->where('proyectos.idProyecto', $id)
        ->first();

        $otrosProyectos = Proyecto::select('proyectos.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
        'region.nombre as nombreRegion', 'tipos_propiedades.nombreTipoPropiedad')
        ->join('comuna', 'comuna.id', '=', 'proyectos.idComuna')
        ->join('provincia', 'provincia.id', '=', 'proyectos.idProvincia')
        ->join('region', 'region.id', '=', 'proyectos.idRegion')
        ->join('tipos_propiedades', 'proyectos.tipoPropiedad', '=', 'tipos_propiedades.idTipoPropiedad')
        ->leftjoin('users', 'users.id', '=', 'proyectos.creadoPor')
        ->where('proyectos.idEstado', 42)
        ->get();

        $amenidades = CaracteristicasPorProyectos::select('caracteristicas_propiedades.*')
        ->join('caracteristicas_propiedades', 'caracteristicas_propiedades.idCaracteristicaPropiedad', '=', 'caracteristicas_por_proyecto.idCaracteristicaPropiedad')
        ->where('caracteristicas_por_proyecto.idProyecto', $id)
        ->get();

        $tipologias = Tipologia::where('idProyecto', $id)->get();

        $fotos = FotoProyecto::where('idProyecto', $id)->get();
        $fotosCercanas = FotoCercana::where('idProyecto', $id)->get();
        $rentas = RentaMensual::get();
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        $invierteAqui = ParametroGeneral::where('parametroGeneral', 'INVIERTE AQUI')->first();
        return view('front-end.single-inversiones', compact('proyecto', 'amenidades', 'tipologias', 'fotos', 'fotosCercanas', 'otrosProyectos',
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram', 'rentas', 'invierteAqui'));
    }
}
