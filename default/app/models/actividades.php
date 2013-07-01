<?php

/**
*
*/
class Actividades extends ActiveRecord
{
    protected $logger = True;

    public function nueva($rama, $fecha, $nombre, $lugar, $tipo, $duracion, $bcp, $ba, $bgi, $creditos) {
        $fecha = date('Y-m-d', strtotime($fecha));
        $existe = $this->find_first("ramas_id = $rama AND fecha = '$fecha'");
        if ($existe) {
            $item = $existe;
        } else {
            $item = $this;
        }
        $item->ramas_id = $rama;
        $item->fecha = $fecha;
        $item->nombre = $nombre;
        $item->lugar = $lugar;
        $item->tipo = $tipo;
        $item->duracion = $duracion;
        $item->bcp = $bcp;
        $item->ba = $ba;
        $item->bgi = $bgi;
        $item->creditos = ($duracion*$bcp)+$ba+$bgi;
        return ($item->save())?True:False;
    }
}

?>