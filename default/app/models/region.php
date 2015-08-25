<?php

class region extends ActiveRecord {

    public function initialize() {
        $this->validates_presence_of('nombre', 'message: Es obligatorio el nombre');
        $this->validates_uniqueness_of('nombre', 'message: Por favor verifique, existe una región con ese nombre');
    }

	public function listar() {
        /*  */
        $columns = "columns: region.id, region.nombre";
        $join = "join: INNER JOIN distrito ON region.id = distrito.region_id
        INNER JOIN grupos ON distrito.id = grupos.distrito_id
        INNER JOIN ramas ON grupos.id = ramas.grupos_id";
        $group = "group: region.id";
        $conditions = "region.estado != 2";

		return $this->find($columns, $conditions, $join, $group);
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

        WHERE
        `region`.`estado` = 1

        GROUP BY `region`.`id`";
        return $this->find_all_by_sql($sql);
    }

    public function listarReporte($ano) {
        $ano_actual= date('Y');
        $ano = ($ano > $ano_actual)?$ano_actual:$ano;
        $sql = "SELECT
        `region`.`id`,
        `region`.`nombre`,
        sum(`creditos`) AS creditos

        FROM `region`

        LEFT JOIN `distrito` ON `region`.`id` = `distrito`.`region_id`
        LEFT JOIN `grupos` ON `distrito`.`id` = `grupos`.`distrito_id`
        LEFT JOIN `ramas` ON `grupos`.`id` = `ramas`.`grupos_id`
        LEFT JOIN `jovenes` ON `ramas`.`id` = ` jovenes`.`ramas_id`
        LEFT JOIN `actividades` ON `ramas`.`id` = `actividades`.`ramas_id`
        LEFT JOIN `jovenes_actividades` ON `ramas`.`id` = `jovenes`.`ramas_id`


        WHERE `region`.`estado` = 1

        GROUP BY `region`.`id` ";
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