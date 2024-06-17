<?php

namespace App\Service\Admin;

class EmpleadoClass
{
    private $DB;

    public function __construct(DBClass $DB){
        $this->DB = $DB;
    }

    public function empleadosLista(){
        $datos = $this->DB->empleadosLista();
        return $datos;
    }
}
