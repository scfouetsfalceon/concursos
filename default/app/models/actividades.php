<?php

/**
*
*/
class Actividades extends ActiveRecord
{
    protected $logger = True;

    public function nueva($rama, $id, $fecha, $nombre, $lugar, $tipo, $duracion, $bcp, $ba, $bgi, $creditos) {
        print $fecha;
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
}

?>
