<?php

/**
* Modelo para actividades Scouts
*
* TODO: Optimizar funciones, eliminar no usadas. Pendiente con las functiones reiterativas**
*/
class Actividades extends ActiveRecord
{
    public function nueva($rama, $data) {
        if (!empty($data['id'])){
            $existe = $this->find_first($data['id']);
            if ($existe) {
                $item = $existe;
            } else {
                $item = $this;
            }
        } else {
            $item = $this;
        }
        $fecha = explode('/', $data['fecha']);
        $ingles = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
        $item->ramas_id = $rama;
        $item->lugar = $data['lugar'];
        $item->nombre = $data['nombre'];
        $item->fecha = $ingles;
        $item->tipo = '0';
        $item->cval = ($data['tipo']==1)?'1':'0';
        $item->cac = ($data['tipo']==2)?'1':'0';
        if ( $data['duracion'] <= 0 ) {
            $item->duracion = '0';
            $item->bcp = 1;
            $item->ba = 2;
            $item->bgi = 1;
        } else {
            $item->duracion = $data['duracion'];
            $item->bcp = $data['bcp'];
            $item->ba = $data['ba'];
            $item->bgi = $data['bgi'];
        }
        return ($item->save())?True:False;
    }

    // FIXME: las siguientes 3 operaciones son casi iguales debo intentar convertir en una sola
    // operación y optimizar este código
    public function listar($unidad, $ano=null, $mes=null){
        $unidad = "conditions: ramas_id = ".ActiveRecord::sql_sanizite($unidad);
        $columns = "columns: id, fecha, nombre, lugar, cac, cval, duracion, bcp, ba, bgi, tipo";
        $ano = (empty($ano))?date('Y'):$ano;
        $mes = (empty($mes))?date('m'):$mes;
        $conditions = $unidad." AND fecha LIKE '$ano-$mes-%'";
        return $this->find($conditions, $columns);
    }

    public function listarConReporte($unidad, $ano=null, $mes=null){
        $unidad = "conditions: ramas_id = ".ActiveRecord::sql_sanizite($unidad);
        $columns = "columns: DISTINCT actividades.id, fecha, nombre, lugar, cac, cval, duracion, bcp, ba, bgi, actividades_id AS reportada";
        $ano = (empty($ano))?date('Y'):$ano;
        $mes = (empty($mes))?date('m'):$mes;
        $join = "join: LEFT JOIN jovenes_actividades ON actividades.id = jovenes_actividades.actividades_id";
        $conditions = $unidad." AND fecha LIKE '$ano-$mes-%'";
        return $this->find($conditions, $columns, $join);
    }

    public function listarSin($unidad, $ano=null, $mes=null){
        $unidad = "conditions: ramas_id = ".ActiveRecord::sql_sanizite($unidad);
        $columns = "columns: actividades.id, jovenes_id, fecha, nombre, lugar, cac, cval, duracion, bcp, ba, bgi";
        $ano = (empty($ano))?date('Y'):$ano;
        $mes = (empty($mes))?date('m'):$mes;
        $join = "join: LEFT JOIN jovenes_actividades ON actividades.id = jovenes_actividades.actividades_id";
        $conditions = $unidad." AND fecha LIKE '$ano-$mes-%'";
        return $this->find($conditions, $columns, $join);
    }

    public function reportada($actividad){
        $actividad = "id = ".ActiveRecord::sql_sanizite($actividad);
        $conditions = $actividad." AND tipo = 1";
        return $this->exists($conditions);
    }

    public function reportar($id){
        $actividad = $this->find_first($id);
        $actividad->tipo = 1;
        return $actividad->update();
    }

    public function ultimasActividades(){
        $nivel = Session::get('nivel');
        $estructura = Session::get('estructura');
        $joins = '';
        $where = '';
        if($nivel == 5){ // Unidad
            $where = 'ramas_id = '.$estructura;
        }
        if($nivel <= 4){ // Grupo
            $joins = 'INNER JOIN ramas ON actividades.ramas_id = ramas.id
            INNER JOIN grupos ON grupos.id = ramas.grupos_id';
            $where = 'grupos.id = '.$estructura;
        }
        if($nivel <= 3){ // Distrito
            $joins .= ' INNER JOIN distrito ON distrito.id = grupos.distrito_id ';
            $where = ' distrito.id ='.$estructura;
        }
        if($nivel <= 2){ // Region
            $joins .= ' INNER JOIN region ON region.id = distrito.region_id';
            $where = 'region.id = '.$estructura;
        }
        if($nivel <= 1){ // Nacional
            $where = '';
        } else {
            $where = 'WHERE ' .$where;
        }
        $sql = "SELECT `actividades`.`fecha`, `actividades`.`nombre`, `actividades`.`lugar`
        FROM actividades

        $joins

        $where

        ORDER BY fecha DESC
        LIMIT 3";

        return $this->find_all_by_sql($sql);
    }
}

?>