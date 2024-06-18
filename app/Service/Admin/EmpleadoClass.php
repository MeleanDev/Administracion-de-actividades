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

    public function departamentos(){
        $datos = $this->DB->departamentosLista();
        return $datos;
    }

    public function crear($datos, $nombreFoto){
        $this->DB->empleadosCrear($datos, $nombreFoto);
    }

    public function guardarImg($datos){
        $ruta = "empleados/img";
        $nombreNuevo = $this->DB->guardarImg($datos, $ruta);
        return $nombreNuevo;
    }

    public function borrarFoto($foto){
        $this->DB->eliminarFotoCarpt($foto);
    }

    public function editar($datos, $id){
        $fotoNombre = null;
        if ($datos->hasFile('foto')) {
            $this->DB->eliminarFotoCarpt($id->foto);
            $fotoNombre = $this->guardarImg($datos);
        }
        $this->DB->empleadosEditar($datos, $fotoNombre, $id);
    }

    public function eliminar($id){
        $this->DB->empleadosEliminar($id);
    }
}
