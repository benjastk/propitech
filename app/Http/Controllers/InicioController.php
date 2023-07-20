<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Foto;
use App\Propiedad;
use App\Region;
use App\Pais;
use App\Comuna;
use App\Noticia;
use App\Provincia;
use App\TipoPropiedad;
use App\TipoComercial;
use App\ParametroGeneral;
use App\PlanAdministracion;
use App\CaracteristicaPlan;
use App\CaracteristicaPlanAsignada;
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
        return view('front-end.home', compact('propiedadesEnArriendo', 'propiedadesEnVenta', 'propiedadesDestacadas', 'comunas', 'paises', 
        'regiones', 'provincias', 'habitaciones', 'noticias', 'planes', 'caracteristicasPlanes',
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram'));
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
            $propiedadesEnVenta = $propiedadesEnVenta1->get();
            return view('front-end.mapa-catalogo-venta', compact('propiedadesEnVenta','comunas', 'paises', 'regiones', 'provincias', 'habitaciones'));
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
            
            return view('front-end.mapa-catalogo-arriendo', compact('propiedadesEnArriendo','comunas', 'paises', 'regiones', 'provincias', 'habitaciones'));
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
            $propiedadesEnArriendo = $propiedadesEnArriendo1->get();
            return view('front-end.mapa-catalogo-arriendo', compact('propiedadesEnArriendo','comunas', 'paises', 'regiones', 'provincias', 'habitaciones'));
        }
    }
    public function mapaCatalogoPropiedades()
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
        ->where('propiedades.idTipoComercial', 2) //Arriendo
        ->get();
        return view('front-end.mapa-catalogo-arriendo', compact('propiedadesEnArriendo','comunas', 'paises', 'regiones', 'provincias', 'habitaciones'));
    }
    public function mapaCatalogoPropiedadesVenta()
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
        $propiedadesEnVenta = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
        'region.nombre as nombreRegion')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->where('propiedades.idEstado', 42)
        ->where('propiedades.idTipoComercial', 1) //venta
        ->get();
        return view('front-end.mapa-catalogo-venta', compact('propiedadesEnVenta','comunas', 'paises', 'regiones', 'provincias', 'habitaciones'));
    }
    public function singleProperty($id)
    {
        $propiedad = Propiedad::select('propiedades.*', 'comuna.nombre as nombreComuna', 'provincia.nombre as nombreProvincia',
        'region.nombre as nombreRegion', 'tipos_propiedades.nombreTipoPropiedad', 'niveles_uso_propiedad.nombreNivelUsoPropiedad', 'users.name',
        'users.email', 'users.telefono')
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
        ->where('caracteristicas_por_propiedades.idPropiedad', 1)
        ->get();

        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        return view('front-end.single-property', compact('propiedad', 'amenidades', 'propiedadesDestacadas1',
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram'));
    }
    public function singleBlog($id)
    {
        $noticia = Noticia::select('noticias.*', 'users.name', 'users.apellido', 'users.avatarImg', 'roles.nombre')
        ->leftjoin('users', 'noticias.idUsuario', '=', 'users.id')
        ->leftjoin('rol_usuario', 'rol_usuario.id_usuario', '=', 'users.id')
        ->leftjoin('roles', 'roles.id', '=', 'rol_usuario.id_rol')
        ->where('idNoticia', $id)
        ->first();
        $noticias = Noticia::where('idNoticia', '!=', $id)
        ->whereNull('deleteOf')
        ->orderBy('fechaPublicacion', 'desc')
        ->get();

        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();

        return view('front-end.blog', compact('noticia', 'noticias',
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram'));
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

        return view('front-end.servicios', compact('planes', 'caracteristicasPlanes',
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram'));
    }
    public function nosotros()
    {
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        return view('front-end.nosotros', compact('telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram'));
    }
    public function preguntasFrecuentes()
    {
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        return view('front-end.preguntasFrecuentes', compact('telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram'));
    }
    public function terminosYCondiciones()
    {
        $telefonoWhatsapp = ParametroGeneral::where('parametroGeneral', 'TELEFONO WHATSAPP')->first();
        $correoHome = ParametroGeneral::where('parametroGeneral', 'CORREO HOME')->first();
        $direccionHome = ParametroGeneral::where('parametroGeneral', 'DIRECCION HOME')->first();
        $twitter = ParametroGeneral::where('parametroGeneral', 'TWITTER')->first();
        $linkedin = ParametroGeneral::where('parametroGeneral', 'LINKEDIN')->first();
        $instagram = ParametroGeneral::where('parametroGeneral', 'INSTAGRAM')->first();
        return view('front-end.terminosYCondiciones', compact('telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram'));
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

        $tiposPropiedades = TipoPropiedad::get();
        $tiposComerciales = TipoComercial::get();
        return view('front-end.publica-tu-propiedad', compact('tiposPropiedades', 'tiposComerciales', 
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram'));
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

        $tiposPropiedades = TipoPropiedad::get();
        $tiposComerciales = TipoComercial::get();
        return view('front-end.trabaja-con-nosotros', compact('tiposPropiedades', 'tiposComerciales', 
        'telefonoWhatsapp', 'correoHome', 'direccionHome', 'twitter', 'linkedin', 'instagram',
        'telefonoContacto', 'telefonoContacto2', 'correoContacto', 'horarioSemana', 'horarioFinDeSemana'));
    }
}
