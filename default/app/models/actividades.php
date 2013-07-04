<?php

/**
*
*/
class Actividades extends ActiveRecord
{
    protected $logger = True;

    public function nueva($rama, $fecha, $nombre, $lugar, $tipo, $duracion, $bcp, $ba, $bgi, $creditos) {
        $fecha = explode('/', $fecha);
        $ingles = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
        $existe = $this->find_first("ramas_id = $rama AND fecha = '$ingles'");
        if ($existe) {
            $item = $existe;
        } else {
            $item = $this;
        }
        $item->ramas_id = $rama;
        $item->fecha = $ingles;
        $item->nombre = $nombre;
        $item->lugar = $lugar;
        $item->cval = ($tipo==1)?'1':'0';
        $item->cac = ($tipo==2)?'1':'0';
        $item->duracion = $duracion;
        $item->bcp = $bcp;
        $item->ba = $ba;
        $item->bgi = $bgi;
        $item->creditos = ($duracion*$bcp)+$ba+$bgi;
        return ($item->save())?True:False;
    }

    public function listar($unidad, $ano=null, $mes=null){
        $columns = "columns: fecha, nombre";
        $ano_actual = date('Y');
        $mes_actual = date('m');
        $unidad = "conditions: ramas_id = $unidad";
        $conditions = $unidad." AND fecha LIKE '$ano-$mes-%'";
        return $this->find($conditions, $columns);
    }
}

?>