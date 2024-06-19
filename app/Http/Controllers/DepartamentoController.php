<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\DepartamentoRequest;
use App\Models\Departamento;
use App\Service\Admin\DepartamentoClass;
use Exception;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    private $departamento;

    public function __construct(DepartamentoClass $departamento)
    {
        $this->departamento = $departamento;
    }

    public function index()
    {
        return view('pages.departamentos');
    }

    public function lista(Request $request)
    {
        if ($request->ajax()) {
            $datos = $this->departamento->lista();
            return datatables()->of($datos)->toJson();
        }
    }

    public function crear(DepartamentoRequest $datos)
    {
        try {
            $this->departamento->crear($datos);
            $respuesta = response()->json([
                'success' => true,
                'informacion' => 'Registro guardado',
                'accion' => 'registrado']);
        } catch (\Throwable $th) {
            $respuesta = response()->json(['error' => true]);
        }
        return $respuesta;
    }

    public function consulta(Departamento $id)
    {
        return response()->json($id);
    }

    public function editar(DepartamentoRequest $datos, Departamento $id)
    {
        try {
            $this->departamento->editar($datos, $id);
            $respuesta = response()->json([
                'success' => true,
                'informacion' => 'Registro Editado',
                'accion' => 'Editado']);
        } catch (\Throwable $th) {
            $respuesta = response()->json(['error' => true]);
        }
        return $respuesta;
    }

    public function eliminar(Departamento $id)
    {
        try {
            $evaluar = $this->departamento->evaluarEliminacion($id->id);
            if ($evaluar) {
                throw new Exception('No se puede eliminar porque hay empleados en este departamento');
            }
            $this->departamento->eliminar($id);
            $respuesta = response()->json(['success' => true,]);
        } catch (\Throwable $th) {
            $respuesta = response()->json([
                'error' => true,
                'mensaje' => $th->getMessage(),
            ]);
        }
        return $respuesta;
    }
}
