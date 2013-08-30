<?php

/**
*
*/
class JovenesActividades extends ActiveRecord
{
    protected $logger = True;

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

    // FIXME: Optimizar y mejorar las consultas de jovenes
    // region, distrito, grupo (se pueden hacer una sola y
    // reducir lineas de códigos)
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

    public function nacional($ano=null, $mes=null)
    {
        $ano = (empty($ano))?date('Y'):$ano;
        $mes = (!empty($mes) && isset($dia->fecha{2}))?$mes:'0'.$mes;
        $fecha = (empty($mes))?$ano.'-%':$ano.'-'.$mes.'-%';
        $sql = "SELECT
        `jovenes`.`id`,
        `region`.`id` AS campo,
        `region`.`nombre` AS campo_nombre,

        `actividades`.`cval`,
        `actividades`.`cac`,
        ((`duracion`*`bcp`)+`ba`+`bgi`) AS creditos

        FROM `demo_concursos`.`jovenes`

        INNER JOIN `ramas` ON `ramas`.`id` = `jovenes`.`ramas_id`
        INNER JOIN `grupos` ON `grupos`.`id` = `ramas`.`grupos_id`
        INNER JOIN `distrito` ON `distrito`.`id` = `grupos`.`distrito_id`
        INNER JOIN `region` ON `region`.`id` = `distrito`.`region_id`

        INNER JOIN `jovenes_actividades` ON `jovenes`.`id` = `jovenes_actividades`.`jovenes_id`
        INNER JOIN `actividades` ON `actividades`.`id` = `jovenes_actividades`.`actividades_id`

        WHERE
        `jovenes`.`estado` = 1
        AND
        `actividades`.`fecha` LIKE '$fecha'

        ORDER BY `region`.`nombre` ASC";

        return $this->find_all_by_sql($sql);
    }

    public function region($id, $ano=null, $mes=null)
    {
        $ano = (empty($ano))?date('Y'):$ano;
        $mes = (!empty($mes) && isset($dia->fecha{2}))?$mes:'0'.$mes;
        $fecha = (empty($mes))?$ano.'-%':$ano.'-'.$mes.'-%';
        $sql = "SELECT
        `jovenes`.`id`,
        `distrito`.`id` AS campo,
        `distrito`.`nombre` AS campo_nombre,

        `actividades`.`cval`,
        `actividades`.`cac`,
        ((`duracion`*`bcp`)+`ba`+`bgi`) AS creditos

        FROM `demo_concursos`.`jovenes`

        INNER JOIN `ramas` ON `ramas`.`id` = `jovenes`.`ramas_id`
        INNER JOIN `grupos` ON `grupos`.`id` = `ramas`.`grupos_id`
        INNER JOIN `distrito` ON `distrito`.`id` = `grupos`.`distrito_id`
        INNER JOIN `region` ON `region`.`id` = `distrito`.`region_id`

        INNER JOIN `jovenes_actividades` ON `jovenes`.`id` = `jovenes_actividades`.`jovenes_id`
        INNER JOIN `actividades` ON `actividades`.`id` = `jovenes_actividades`.`actividades_id`

        WHERE
        `jovenes`.`estado` = 1
        AND
        `region`.`id` = $id
        AND
        `actividades`.`fecha` LIKE '$fecha'

        ORDER BY `distrito`.`nombre` ASC";

        return $this->find_all_by_sql($sql);
    }

    public function distrito($id, $ano=null, $mes=null)
    {
        $ano = (empty($ano))?date('Y'):$ano;
        $mes = (!empty($mes) && isset($dia->fecha{2}))?$mes:'0'.$mes;
        $fecha = (empty($mes))?$ano.'-%':$ano.'-'.$mes.'-%';
        $sql = "SELECT
        `jovenes`.`id`,
        `grupos`.`id` AS campo,
        `grupos`.`nombre` AS campo_nombre,

        `actividades`.`cval`,
        `actividades`.`cac`,
        ((`duracion`*`bcp`)+`ba`+`bgi`) AS creditos

        FROM `demo_concursos`.`jovenes`

        INNER JOIN `ramas` ON `ramas`.`id` = `jovenes`.`ramas_id`
        INNER JOIN `grupos` ON `grupos`.`id` = `ramas`.`grupos_id`
        INNER JOIN `distrito` ON `distrito`.`id` = `grupos`.`distrito_id`

        INNER JOIN `jovenes_actividades` ON `jovenes`.`id` = `jovenes_actividades`.`jovenes_id`
        INNER JOIN `actividades` ON `actividades`.`id` = `jovenes_actividades`.`actividades_id`

        WHERE
        `jovenes`.`estado` = 1
        AND
        `distrito`.`id` = $id
        AND
        `actividades`.`fecha` LIKE '$fecha'

        ORDER BY `grupos`.`nombre` ASC";

        return $this->find_all_by_sql($sql);
    }

    public function grupo($id, $ano=null, $mes=null)
    {
        $ano = (empty($ano))?date('Y'):$ano;
        $mes = (!empty($mes) && isset($dia->fecha{2}))?$mes:'0'.$mes;
        $fecha = (empty($mes))?$ano.'-%':$ano.'-'.$mes.'-%';
        $sql = "SELECT
        `jovenes`.`id`,
        `ramas`.`id` AS campo,
        `tipo`.`nombre` AS campo_nombre,

        `actividades`.`cval`,
        `actividades`.`cac`,
        ((`duracion`*`bcp`)+`ba`+`bgi`) AS creditos

        FROM `demo_concursos`.`jovenes`

        INNER JOIN `ramas` ON `ramas`.`id` = `jovenes`.`ramas_id`
        INNER JOIN `tipo` ON `tipo`.`id` = `ramas`.`tipo_id`
        INNER JOIN `grupos` ON `grupos`.`id` = `ramas`.`grupos_id`

        INNER JOIN `jovenes_actividades` ON `jovenes`.`id` = `jovenes_actividades`.`jovenes_id`
        INNER JOIN `actividades` ON `actividades`.`id` = `jovenes_actividades`.`actividades_id`

        WHERE
        `jovenes`.`estado` = 1
        AND
        `grupos`.`id` = $id
        AND
        `actividades`.`fecha` LIKE '$fecha'

        ORDER BY `tipo`.`id` ASC";

        return $this->find_all_by_sql($sql);
    }
}

?>