<?php

/**
*
*/
class GrupoController extends AppController
{

    public function nueva() {
        if (Input::post('registrar')) {
            $nombre = Input::post('nombre');
            $region = Filter::get(Input::post('distrito_id'), 'int');
            $id = Load::model('grupos')->nuevo($nombre, $region);
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
        if ( $who == 1 ) {
            $id = Load::model('grupos')->borrar($id);
            if ( $id ) Flash::valid("Grupo borrada exitosamente");
        } else {
            Load::model('email');
            $notificacion = new email();
            $notificacion->AdministradorEliminar($id, $who, "Grupo");
        }
    }

    public function activar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $nombre = Input::post('nombre');
        $id = Load::model('grupos')->activar($id);
        if ( $id ) Flash::valid("Grupo activada exitosamente");
    }

    public function desactivar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $nombre = Input::post('nombre');
        $id = Load::model('grupos')->desactivar($id);
        if ( $id ) Flash::valid("Grupo desactivada exitosamente");
    }

    public function listar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $lista = Load::model('grupos')->listar($id);
        if (count($lista) != 0) {
            $salida = array('status'=>'success', 'lista'=>$lista);
        } else {
            $salida = array('status'=>'error');
        }

        echo json_encode($salida);
    }

}

?>