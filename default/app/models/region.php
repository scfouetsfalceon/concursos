<?php

class region extends ActiveRecord {
	protected $logger =  True;

    public function initialize() {
        $this->validates_presence_of('nombre', 'message: Es obligatorio el nombre');
        $this->validates_uniqueness_of('nombre', 'message: Por favor verifique, existe una región con ese nombre');
    }

	public function listar() {
		return $this->find('estado != 2');
	}

    public function listarConActividades() {
        $sql = "SELECT 
        `region`.`id`,
        `region`.`nombre`, 
        sum(`actividades`.`cval`) AS cval,
        sum(`actividades`.`cac`) AS cac

        FROM `region`

        LEFT JOIN `distrito` ON `region`.`id` = `distrito`.`region_id`
        LEFT JOIN `grupos` ON `distrito`.`id` = `grupos`.`distrito_id`
        LEFT JOIN `ramas` ON `grupos`.`id` = `ramas`.`grupos_id`
        LEFT JOIN `actividades` ON `ramas`.`id` = `actividades`.`ramas_id`

        WHERE `region`.`estado` == 1

        GROUP BY `region`.`id`";
        return $this->find_all_by_sql($sql);
    }

    public function nuevo($nombre) {
        $this->nombre = $nombre;
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
}

?>