<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\Foto;
use Image;
class AddMarkerImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fotos = Foto::select('fotos.*')
        ->join('propiedades', 'propiedades.id', '=', 'fotos.idPropiedad')
        ->where('fotos.marcaDeAgua', 0)
        ->whereIn('propiedades.idEstado', [42, 43, 45])
        ->get();
        if($fotos)
        {
            foreach ($fotos as $foto) 
            {
                $antiguo = $foto->nombreArchivo;
                if(file_exists(('img/propiedad/' . $foto->nombreArchivo))) 
                {
                    $img = \Image::make(public_path('img/propiedad/' . $foto->nombreArchivo));
                    /* insert watermark at bottom-right corner with 10px offset */
                    $img->insert(public_path('front/logoopacity2.png'), 'center');
                    $path = public_path() . '/img/propiedad/';
        
                    $fileName = uniqid().'.png';
                    $img->save($path . $fileName);
                    $foto->nombreArchivo = $fileName;
                    $foto->marcaDeAgua = 1;
                    $foto->save();
                    File::delete(public_path('img/propiedad/' . $antiguo));
                }
            }
        }
    }
}
