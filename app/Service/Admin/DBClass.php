<?php

namespace App\Service\Admin;

use App\Models\Departamento;
use App\Models\Empleado;

class DBClass
{
    /////////////////////////////////////////////////////////////////////////////
    //                          Consultas                                      //
    /////////////////////////////////////////////////////////////////////////////

    // Empleados
        // Lista
        public function empleadosLista(){
            $datos = Empleado::all();
            return $datos;
        }

        // Crear
        public function empleadosCrear($datos, $nombreFoto){
            $emplea = new Empleado();
            $emplea->codigo = $datos->input('codigo');
            $emplea->Pnombre = $datos->input('Pnombre');
            $emplea->Snombre = $datos->input('Snombre');
            $emplea->Papellido = $datos->input('Papellido');
            $emplea->Sapellido = $datos->input('Sapellido');
            $emplea->correo = $datos->input('correo');
            $emplea->telefono = $datos->input('telefono');
            $emplea->departamento_id = $datos->input('departamento_id');
            $emplea->foto = $nombreFoto;
            $emplea->save();
        }

        // Editar
        public function empleadosEditar($datos, $nombreFoto, $id){

            if ($nombreFoto) {
                $id->foto = $nombreFoto;
            }

            $id->codigo = $datos->input('codigo');
            $id->Pnombre = $datos->input('Pnombre');
            $id->Snombre = $datos->input('Snombre');
            $id->Papellido = $datos->input('Papellido');
            $id->Sapellido = $datos->input('Sapellido');
            $id->correo = $datos->input('correo');
            $id->telefono = $datos->input('telefono');
            $id->departamento_id = $datos->input('departamento_id');
            $id->save();
        }

        // Eliminar
        public function empleadosEliminar($id){
            $id->delete();
        }

        // Buscar
        public function empleadoDepartameto($id){
            $dato = Empleado::where('departamento_id', $id)->first();
            if ($dato) {
                return $dato;
            }
            return $dato = false;
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

        // Editar
        public function departamentoEditar($datos, $id){
            $id->nombre = $datos->input('nombre');
            $id->save();
        }

        // Eliminar
        public function departamentoEliminar($id){
            $id->delete();
        }

    /////////////////////////////////////////////////////////////////////////////
    //                          APP                                           //
    /////////////////////////////////////////////////////////////////////////////

    // Borrar archivo de la app
    public function eliminarFotoCarpt($foto){
        unlink(public_path('storage/'.$foto));
    }

    // Guardar img
    public function guardarImg($datos, $ruta){
        $extension = $datos->file('foto')->getClientOriginalExtension();
        $filename = time().'.'.$extension;
        $datos->file('foto')->storeAs('public/'.$ruta, $filename);

        $nombreActualizado = $ruta.'/'.$filename;
        return $nombreActualizado;
}
}
