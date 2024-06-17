<?php

namespace App\Service\Admin;

use App\Models\Departamento;
use App\Models\Empleado;

class DBClass
{
    /////////////////////////////////////////////////////////////////////////////
    //                          Adminstrador                                   //
    /////////////////////////////////////////////////////////////////////////////

    // Empleados
        // Lista
        public function empleadosLista(){
            $datos = Empleado::all();
            return $datos;
        }
    
    // Departamentos
        // Lista 
        public function departamentosLista(){
            $datos = Departamento::all();
            return $datos;
        }

        // Crear
        public function departamentoCrear($datos){
            $departamen = new Departamento();
            $departamen->nombre = $datos->input('nombre');
            $departamen->save();
        }

        // Consulta ID
        public function departamentoConsultaId($id){
            $datos = Departamento::find($id);
            return $datos;
        }

        // Editar
        public function departamentoEditar($datos, $id){
            $id->nombre = $datos->input('nombre');
            $id->save();
        }

        // Eliminar
        public function departamentoEliminar($id){
            $id->delete();
        }
}
