<?php

/**
*
*/
class Actividades extends ActiveRecord
{
    protected $logger = True;

    public function nueva($rama, $id, $fecha, $nombre, $lugar, $tipo, $duracion, $bcp, $ba, $bgi, $creditos) {
        $fecha = explode('/', $fecha);
        $ingles = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
        if (!empty($id)){
            $existe = $this->find_first($id);
            if ($existe) {
                $item = $existe;
            } else {
                $item = $this;
            }
        } else {
            $item = $this;
        }
        $item->ramas_id = $rama;
        $item->fecha = $ingles;
        $item->nombre = $nombre;
        $item->lugar = $lugar;
        $item->tipo = '0';
        $item->cval = ($tipo==1)?'1':'0';
        $item->cac = ($tipo==2)?'1':'0';
        $item->duracion = $duracion;
        $item->bcp = $bcp;
        $item->ba = $ba;
        $item->bgi = $bgi;
        // $item->creditos = ($duracion*$bcp)+$ba+$bgi;
        return ($item->save())?True:False;
    }

    public function listar($unidad, $ano=null, $mes=null){
        $unidad = ActiveRecord::sql_sanizite($unidad);
        $columns = "columns: id, fecha, nombre, lugar, cac, cval, duracion, bcp, ba, bgi";
        $ano = (empty($ano))?date('Y'):$ano;
        $mes = (empty($mes))?date('m'):$mes;
        $unidad = "conditions: ramas_id = $unidad";
        $conditions = $unidad." AND fecha LIKE '$ano-$mes-%'";
        return $this->find($conditions, $columns);
    }

    public function ultimasActividades(){
        $nivel = Session::get('nivel');
        $estructura = Session::get('estructura_id');
        $joins = '';
        if($nivel == 5){ // Unidad
            $where = 'ramas_id = '.$estructura;
        }
        if($nivel >= 4){ // Grupo
            $joins = 'INNER JOIN ramas ON actividades.ramas_id = ramas.id
            INNER JOIN grupos ON grupos.id = ramas.grupos_id';
            $where = 'grupos.id = '.$estructura;
        }
        if($nivel >= 3){ // Distrito
            $joins = 'INNER JOIN distrito ON distrito.id = grupo.distrito_id' + $joins;
            $where = ' distrito.id ='.$estructura;
        }
        if($nivel >= 2){ // Region
            $joins = 'INNER JOIN region ON region.id = distrito.region_id' + $joins;
            $where = 'region.id = '.$estructura;
        }
        if($nivel >= 1){ // Nacional
            $where = '';
        }
        $sql = "SELECT fecha, nombre, lugar
        FROM actividades

        $joins

        $where

        ORDER BY fecha DESC
        LIMIT 3";

        return $this->find_all_by_sql($sql);
    }
}

?>