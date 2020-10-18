<?php

namespace App\Http\Controllers;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class ReservasController extends Controller
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
        return view('reservas.index');
    }

    public function listar_registros()
    {
        $reservas=Reserva::all();
        return $reservas;
    }

    public function create(){
        return view('reservas.nuevo');
    }

    public function store(Request $request){
        $reserva=new Reserva();
        $reserva->id_cliente=$request->cliente_identificacion;
        $reserva->nombre_cliente=$request->cliente_nombre;
        $reserva->nombre_propiedad=$request->propiedad_nombre;
        $reserva->tipo=$request->propiedad_tipo;
        $reserva->precio_noche=$request->precio_noche;
        $reserva->precio_total=$request->precio_total;
        $reserva->fecha_inicio=$request->fecha_entrada;
        $reserva->fecha_fin=$request->fecha_salida;
        $reserva->estado="EN ALQUILER";
        $reserva->propiedad_id=$request->id_propiedad;
        $reserva->save();
        $propiedad=Propiedad::find($request->id_propiedad);
        $propiedad->estado_id=3;
        $propiedad->save();
    }

    public function anular(Request $request){
        $reserva=Reserva::find($request->id);
        $reserva->estado="ANULADA";
        $reserva->save();
        $propiedad=Propiedad::find($request->propiedad_id);
        $propiedad->estado_id=1;
        $propiedad->save();
    }
}
