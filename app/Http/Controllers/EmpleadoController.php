<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\EmpleadoRequest;
use App\Models\Empleado;
use App\Service\Admin\EmpleadoClass;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    private $empleado;

    public function __construct(EmpleadoClass $empleado)
    {
        $this->empleado = $empleado;
    }

    public function index()
    {
        $departamentos = $this->empleado->departamentos();
        return view('pages.empleados', compact('departamentos'));
    }

    public function lista(Request $request)
    {
        if ($request->ajax()) {
            $datos = $this->empleado->empleadosLista();
            foreach ($datos as $item) {
                $item->fotoUrl = asset('storage/'.$item->foto);
                $item->depa = $item->departamento->nombre;
            }
            return datatables()->of($datos)->toJson();
        }
    }

    public function crear(EmpleadoRequest $datos)
    {
        try {
            $nombreFoto = $this->empleado->guardarImg($datos);
            $this->empleado->crear($datos, $nombreFoto);
            $respuesta = response()->json([
                'success' => true,
                'informacion' => 'Registro guardado',
                'accion' => 'registrado'
            ]);
        } catch (\Throwable $th) {
            $this->empleado->borrarFoto($nombreFoto);
            $respuesta = response()->json(['error' => true]);
        }
        return $respuesta;
    }

    public function consulta($id)
    {
        $dato = $this->empleado->consultaId($id);
        $dato->fotoUrl = asset('storage/'.$dato->foto);
        $dato->depa = $dato->departamento->nombre;
        return response()->json($dato);
    }

    public function editar(Request $datos, Empleado $id)
    {
        try {
            $this->empleado->editar($datos, $id);
            $respuesta = response()->json([
                'success' => true,
                'informacion' => 'Registro editado en el sistema',
                'accion' => 'editado'
            ]);
        } catch (\Throwable $th) {
            $respuesta = response()->json(['error' => true]);
        }
        return $respuesta;
    }

    public function eliminar(Empleado $id)
    {
        try {
            $this->empleado->borrarFoto($id->foto);
            $this->empleado->eliminar($id);
            $respuesta = response()->json(['success' => true,]);
        } catch (\Throwable $th) {
            $respuesta = response()->json(['error' => true,]);
        }
        return $respuesta;
    }
}
