<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
class ClientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('clientes.index');
    }

    public function create(){
        return view('clientes.nuevo');
    }

    public function store(Request $request){
        $cliente=Cliente::create($request->all());
    }

    public function listar_registros()
    {
        $clientes=Cliente::all();
        return $clientes;
    }

    public function destroy(Request $request){
        Cliente::destroy($request->cliente_id);
    }

    public function update(Request $request,$id){
        $cliente =Cliente::find($id);
        $cliente->update($request->all());
    }

    public function edit(Cliente $cliente){
        $data['cliente']=$cliente;
        return view('clientes.editar',$data);
    }
}
