<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Propiedad;
use App\Models\Tipo;

class PropiedadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('propiedades.index');
    }

    public function create(){
        $tipos=Tipo::select('id as value','nombre as text')->get();
        $data['tipos']=$tipos;
        return view('propiedades.nuevo',$data);
    }

    public function store(Request $request){
        $request['estado_id']=1;
        $propiedad=Propiedad::create($request->all());
        if($request->hasFile('url_imagen')){
            $path=Storage::disk('public')->put('imagenes',$request->file('url_imagen'));
            $propiedad->fill(['url_imagen'=>'archivos/'.$path])->save();
        };
    }

    public function listar_registros()
    {
        $propiedades=Propiedad::select('propiedades.id','propiedades.titulo','propiedades.descripcion','tipos.nombre as tipo','estados.nombre as estado','propiedades.precio_alquiler','propiedades.precio_venta','propiedades.url_imagen')
        ->join('tipos','tipos.id','propiedades.tipo_id')
        ->join('estados','estados.id','propiedades.estado_id')->get();
        return $propiedades;
    }

    public function destroy(Request $request){
        Propiedad::destroy($request->propiedad_id);
    }

    public function update(Request $request,$id){
        $propiedad =Propiedad::find($id);
        $propiedad->update($request->all());
        if($request->hasFile('url_imagen')){
            $path=Storage::disk('public')->put('imagenes',$request->file('url_imagen'));
            $propiedad->fill(['url_imagen'=>asset($path)])->save();
        }
    }

    public function edit(Propiedad $propiedad){
        $tipos=Tipo::select('id as value','nombre as text')->get();
        $data['tipos']=$tipos;
        $data['propiedad']=$propiedad;
        return view('propiedades.editar',$data);
    }

    public function filtros(Request $request){
        if($request->tipo==null){
            $propiedades=Propiedad::select('propiedades.id','propiedades.titulo','propiedades.descripcion','tipos.nombre as tipo','estados.nombre as estado','propiedades.precio_alquiler','propiedades.precio_venta','propiedades.url_imagen')
            ->join('tipos','tipos.id','propiedades.tipo_id')
            ->join('estados','estados.id','propiedades.estado_id')->get();
            return $propiedades;
        }
        else{
            $propiedades=Propiedad::select('propiedades.id','propiedades.titulo','propiedades.descripcion','tipos.nombre as tipo','estados.nombre as estado','propiedades.precio_alquiler','propiedades.precio_venta','propiedades.url_imagen')
            ->join('tipos','tipos.id','propiedades.tipo_id')
            ->join('estados','estados.id','propiedades.estado_id')
            ->where('propiedades.tipo_id',$request->tipo)->get();
            return $propiedades;
        }
       
    }
}
