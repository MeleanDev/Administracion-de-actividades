<?php

namespace App\Http\Controllers;

use App\Service\Admin\EmpleadoClass;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    private $empleado;

    public function __construct(EmpleadoClass $empleado){
        $this->empleado = $empleado;
    }

    public function index(){
        return view('pages.empleados');
    }

    public function lista(Request $request){
        if ($request->ajax()) {
            $datos = $this->empleado->empleadosLista();
            return datatables()->of($datos)->toJson();
        }  
    }

}
