<?php

namespace App\Service\Admin;

class DepartamentoClass
{
    private $DB;

    public function __construct(DBClass $DB){
        $this->DB = $DB;
    }

    public function lista(){
        $datos = $this->DB->departamentosLista();
        return $datos;
    }

    public function crear($datos){
        $this->DB->departamentoCrear($datos);
    }

    public function editar($datos, $id){
        $this->DB->departamentoEditar($datos, $id);
    }

    public function evaluarEliminacion($id){
        $datos = $this->DB->empleadoDepartameto($id);
        if ($datos) {
            return $datos;
        }
        return $datos = false;
    }

    public function eliminar($id){
        $this->DB->departamentoEliminar($id);
    }
}
