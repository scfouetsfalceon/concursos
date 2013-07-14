<?php

/**
*
*/
class JovenesActividades extends ActiveRecord
{

    public function nuevo($joven, $actividad) {
        $this->jovenes_id = $joven;
        $this->actividades_id = $actividad;
        $this->usuarios_id = Session::get('id');
        $this->estado = 1;
        return $this->create();
    }

    public function modificar($joven, $actividad) {
        $this->delete("actividades_id = '$actividad'");
        return $this->nuevo($joven, $actividad);
    }

    public function jovenes($unidad, $ano=null, $mes=null)
    {
        $ano = (empty($ano))?date('Y'):$ano;
        $mes = (!empty($mes) && isset($dia->fecha{2}))?$mes:'0'.$mes;
        $fecha = (empty($mes))?$ano.'-%':$ano.'-'.$mes.'-%';
        $sql = "SELECT
        `jovenes`.`id`,
        `jovenes`.`credencial`,
        `jovenes`.`primer_nombre`,
        `jovenes`.`segundo_nombre`,
        `jovenes`.`primer_apellido`,
        `jovenes`.`segundo_apellido`,

        -- Campos Base
        `jovenes`.`ramas_id`,
        `actividades`.`id` AS actividades,
        `actividades`.`cval`,
        `actividades`.`cac`,
        ((`duracion`*`bcp`)+`ba`+`bgi`) AS creditos

        FROM `demo_concursos`.`jovenes`

        INNER JOIN `jovenes_actividades` ON `jovenes`.`id` = `jovenes_actividades`.`jovenes_id`
        INNER JOIN `actividades` ON `actividades`.`id` = `jovenes_actividades`.`actividades_id`

        WHERE
        `jovenes`.`estado` = 1
        AND
        `jovenes`.`ramas_id` = $unidad
        AND
        `actividades`.`fecha` LIKE '$fecha'";

        return $this->find_all_by_sql($sql);
    }
}

?>