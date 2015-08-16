<?php

class ramas extends ActiveRecord {
    protected $logger = True;

	public function getRamas($grupo=Null) {

        $grupo=(!isset($grupo))?Session::get('estructura'):$grupo;

        $columns = "columns: ramas.id, tipo.nombre";
        $join = "join: INNER JOIN tipo ON tipo.id = ramas.tipo_id";
        $group = "group: ramas.id";
        $conditions = "grupos_id = $grupo";

        return $this->find($columns, $conditions, $join, $group);

	}

    public function buscar($id) {
        $columns="columns: id, tipo_id, grupos_id";
        return $this->find($id,$columns);
    }

    public function listarConActividades($grupo) {
        $sql = "SELECT
        `ramas`.`id`,
        `tipo`.`nombre`,
        sum(`actividades`.`cval`) AS cval,
        sum(`actividades`.`cac`) AS cac

        FROM `ramas`

        INNER JOIN `tipo` ON `tipo`.`id` = `ramas`.`tipo_id`
        LEFT JOIN `actividades` ON `ramas`.`id` = `actividades`.`ramas_id`

        WHERE
        `grupos_id` = '$grupo'

        GROUP BY `ramas`.`id`";
        return $this->find_all_by_sql($sql);
    }

    public function nuevo($tipo, $grupo) {
        $this->tipo_id = $tipo;
        $this->grupos_id = $grupo;
        return $this->create();
    }

    public function proximaRama($rama, $grupo, $sexo){
        $y = " AND ";
        $grupo = "grupos_id = ".$grupo;
        $sexo = "tipo.sexo = ".$sexo;
        $rama = "ramas.id > ".$rama;
        $columns = "columns: ramas.id";
        $joins = "join: INNER JOIN tipo ON tipo_id = tipo.id";
        $conditions = $grupo.$y.$sexo.$y.$rama;
        return $this->find_first($conditions,$columns,$joins);
    }
}

?>