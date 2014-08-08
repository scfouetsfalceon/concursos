<?php

class distrito extends ActiveRecord {
	protected $logger =  True;

	public function listar($region) {
        /* SELECT region.nombre, count(jovenes.id) AS cantidad FROM `region`
        INNER JOIN distrito ON region.id = distrito.region_id
        INNER JOIN grupos ON distrito.id = grupos.distrito_id
        INNER JOIN ramas ON grupos.id = ramas.grupos_id
        INNER JOIN jovenes ON ramas.id = jovenes.ramas_id
        GROUP BY region.id */
        $columns = "columns: distrito.id, distrito.nombre, count(jovenes.id) AS cantidad";
        $join = "join: INNER JOIN grupos ON distrito.id = grupos.distrito_id
        INNER JOIN ramas ON grupos.id = ramas.grupos_id
        INNER JOIN jovenes ON ramas.id = jovenes.ramas_id";
        $group = "group: distrito.id";
        $conditions = 'region_id = '.$region.' AND distrito.estado != 2 AND jovenes.estado != 2 ';

        return $this->find($columns, $conditions, $join, $group);
    }

    public function listarConActividades($region) {
        $sql = "SELECT 
        `distrito`.`id`,
        `distrito`.`nombre`, 
        sum(`actividades`.`cval`) AS cval,
        sum(`actividades`.`cac`) AS cac

        FROM `distrito`

        LEFT JOIN `grupos` ON `distrito`.`id` = `grupos`.`distrito_id`
        LEFT JOIN `ramas` ON `grupos`.`id` = `ramas`.`grupos_id`
        LEFT JOIN `actividades` ON `ramas`.`id` = `actividades`.`ramas_id`

        WHERE `distrito`.`region_id` = '$region' AND `distrito`.`estado` = 1

        GROUP BY `distrito`.`id`";
        return $this->find_all_by_sql($sql);
    }

    public function nuevo($nombre, $region) {
        $this->nombre = $nombre;
        $this->region_id = $region;
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