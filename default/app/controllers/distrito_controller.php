<?php

/**
*
*/
class DistritoController extends AppController
{

    public function nueva() {
        if (Input::post('registrar')) {
            $nombre = Input::post('nombre');
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
        $who = Session::get('id');
        if ( $who != 1 ) {
            $id = Load::model('distrito')->borrar($id);
            if ( $id ) Flash::valid("Distrito borrada exitosamente");
        } else {
            Load::model('email');
            $notificacion = new email();
            $notificacion->AdministradorEliminar($id, $who, "Distrito");
        }
    }

    public function activar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $nombre = Input::post('nombre');
        $id = Load::model('distrito')->activar($id);
        if ( $id ) Flash::valid("Distrito activada exitosamente");
    }

    public function desactivar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $nombre = Input::post('nombre');
        $id = Load::model('distrito')->desactivar($id);
        if ( $id ) Flash::valid("Distrito desactivada exitosamente");
    }

    public function listar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $lista = Load::model('distrito')->listar($id);
        if (count($lista) != 0) {
            $salida = array('status'=>'success', 'lista'=>$lista);
        } else {
            $salida = array('status'=>'error');
        }

        echo json_encode($salida);
    }

}

?>