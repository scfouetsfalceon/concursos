<?php

class grupos extends ActiveRecord {
	protected $logger = True;

	public function listar($distrito) {
		return $this->find('distrito_id = '.$distrito.' AND estado != 2');
    }

    public function listarConActividades($distrito) {
        $sql = "SELECT 
        `grupos`.`id`,
        `grupos`.`nombre`, 
        sum(`actividades`.`cval`) AS cval,
        sum(`actividades`.`cac`) AS cac

        FROM `grupos`

        LEFT JOIN `ramas` ON `grupos`.`id` = `ramas`.`grupos_id`
        LEFT JOIN `actividades` ON `ramas`.`id` = `actividades`.`ramas_id`

        WHERE `grupos`.`distrito_id` = '$distrito' AND `grupos`.`estado` = 1

        GROUP BY `grupos`.`id`";
        return $this->find_all_by_sql($sql);
    }

    public function nuevo($nombre, $distrito) {
        $this->nombre = $nombre;
        $this->distrito_id = $distrito;
        $this->estado = '1';
        return ($this->create())?$this->id:False;
    }

    public function estado($id, $estado=NULL) {
        $rs = $this->find_first($id);
        $rs->estado = (isset($estado))?$estado:!$rs->estado;
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
