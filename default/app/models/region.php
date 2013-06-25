<?php

class region extends ActiveRecord {
	protected $logger =  True;

    public function initialize() {
        $this->validates_presence_of('nombre', 'message: Es obligatorio el nombre');
        $this->validates_uniqueness_of('nombre', 'message: Por favor verifique, existe una región con ese nombre');
    }

	public function listar() {
		return $this->find('estatus != 2');
	}

    public function nuevo($nombre) {
        $this->nombre = $nombre;
        $this->estatus = '1';
        return ($this->create())?$this->id:False;
    }

    public function estado($id, $estado=NULL) {
        $rs = $this->find_first($id);
        $rs->estatus = (isset($estado))?$estado:!$rs->estatus;
        return $rs->update();
    }

    public function desactivar($id) {
        return $this->estado($id, '0');
    }

    public function activar($id) {
        return $this->estado($id, '1');
    }

    public function borrar($id) {
        return $this->estado($id, '2');
    }
}

?>