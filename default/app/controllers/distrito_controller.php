<?php

/**
*
*/
class DistritoController extends AppController
{

    public function nueva() {
        if (Input::post('registrar')) {
            $nombre = mysql_real_escape_string(Input::post('nombre'));
            $region = Filter::get(Input::post('region_id'), 'int');
            $id = Load::model('distrito')->nuevo($nombre, $region);
            if ( $id ) Flash::valid($id);
        }
    }

    public function borrar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $nombre = mysql_real_escape_string(Input::post('nombre'));
        $id = Load::model('distrito')->borrar($id);
        if ( $id ) Flash::valid("Distrito borrada exitosamente");
    }

    public function activar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $nombre = mysql_real_escape_string(Input::post('nombre'));
        $id = Load::model('distrito')->activar($id);
        if ( $id ) Flash::valid("Distrito activada exitosamente");
    }

    public function desactivar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $nombre = mysql_real_escape_string(Input::post('nombre'));
        $id = Load::model('distrito')->desactivar($id);
        if ( $id ) Flash::valid("Distrito desactivada exitosamente");
    }

}

?>