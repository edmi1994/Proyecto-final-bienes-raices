<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Propiedad;
class VentasController extends Controller
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
        return view('ventas.index');
    }

    public function listar_registros()
    {
        $ventas=Venta::all();
        return $ventas;
    }

    public function create(){
        return view('ventas.nuevo');
    }

    public function clientes(){
        $clientes=Cliente::all();
        return $clientes;
    }

    public function propiedades(){
        $propiedades=Propiedad::select('propiedades.id','propiedades.titulo as nombre','propiedades.descripcion','tipos.nombre as tipo','estados.nombre as estado','propiedades.precio_alquiler','propiedades.precio_venta as precio','propiedades.url_imagen')
        ->join('tipos','tipos.id','propiedades.tipo_id')
        ->join('estados','estados.id','propiedades.estado_id')
        ->where('propiedades.estado_id',1)
        ->get();
        return $propiedades;
    }

    public function store(Request $request){
        $venta=new Venta();
        $venta->id_cliente=$request->cliente_identificacion;
        $venta->nombre_cliente=$request->cliente_nombre;
        $venta->nombre_propiedad=$request->propiedad_nombre;
        $venta->tipo=$request->propiedad_tipo;
        $venta->precio=$request->propiedad_nombre;
        $venta->estado="VENDIDA";
        $venta->propiedad_id=$request->id_propiedad;
        $venta->save();
        $propiedad=Propiedad::find($request->id_propiedad);
        $propiedad->estado_id=2;
        $propiedad->save();
    }
    public function anular(Request $request){
        $venta=Venta::find($request->id);
        $venta->estado="ANULADA";
        $venta->save();
        $propiedad=Propiedad::find($request->propiedad_id);
        $propiedad->estado_id=1;
        $propiedad->save();
    }
}
