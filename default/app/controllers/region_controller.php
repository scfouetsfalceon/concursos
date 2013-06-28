<?php

/**
*
*/
class RegionController extends AppController
{

    public function nueva() {
        if (Input::post('registrar')) {
            $nombre = Input::post('nombre');
            $id = Load::model('region')->nuevo($nombre);
            if ( $id ) Flash::valid($id);
        }
    }

    public function borrar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $nombre = Input::post('nombre');
        $id = Load::model('region')->borrar($id);
        if ( $id ) Flash::valid("Región borrada exitosamente");
    }

    public function activar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $nombre = Input::post('nombre');
        $id = Load::model('region')->activar($id);
        if ( $id ) Flash::valid("Región activada exitosamente");
    }

    public function desactivar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $nombre = Input::post('nombre');
        $id = Load::model('region')->desactivar($id);
        if ( $id ) Flash::valid("Región desactivada exitosamente");
    }

}

?>