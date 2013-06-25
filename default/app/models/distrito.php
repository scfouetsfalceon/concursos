<?php

class distrito extends ActiveRecord {
	protected $logger =  True;

	public function listar($region) {
		return $this->find('region_id = '.$region.' AND estatus != 2');
    }

    public function nuevo($nombre, $region) {
        $this->nombre = $nombre;
        $this->region_id = $region;
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