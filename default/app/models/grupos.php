<?php

class grupos extends ActiveRecord {
	protected $logger = True;

	public function listar($distrito) {
		return $this->find('distrito_id = '.$distrito.' AND estatus != 2');
    }

    public function nuevo($nombre, $distrito) {
        $this->nombre = $nombre;
        $this->distrito_id = $distrito;
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

    function after_create() {
        $grupo_id = $this->id;
        $ramas = Load::model('ramas');
        $ramas->nuevo(1, $grupo_id);
        $ramas->nuevo(2, $grupo_id);
        $ramas->nuevo(3, $grupo_id);
        $ramas->nuevo(4, $grupo_id);
        $ramas->nuevo(5, $grupo_id);
        $ramas->nuevo(6, $grupo_id);
    }
}

?>
