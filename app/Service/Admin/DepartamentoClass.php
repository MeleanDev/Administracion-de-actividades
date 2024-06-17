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

    public function consultaId($id){
        $datos = $this->DB->departamentoConsultaId($id);
        return $datos;
    }

    public function editar($datos, $id){
        $this->DB->departamentoEditar($datos, $id);
    }

    public function eliminar($id){
        $this->DB->departamentoEliminar($id);
    }
}
