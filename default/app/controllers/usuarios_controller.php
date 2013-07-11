<?php

/**
*
*/
class UsuariosController extends AppController
{

    public function index($pag='pag', $page=1) {
        $nivel = Session::get('nivel');
        $estructura = Session::get('estructura');
        $this->lista = Load::model('usuarios')->listar($nivel, $estructura, $page);
    }

    public function nuevo() {
        $this->nivel = Session::get('nivel');
        $this->estructura = Session::get('estructura');

        if (Input::hasPost('adulto')) {
            Load::model('usuarios');
            $usuario = new Usuarios(Input::post('adulto'));
            if ( $usuario->guardar() ) {
                Flash::valid('Usuario creado exitosamente!!!');
                Router::redirect('usuarios/');
            }
        }
    }

    public function editar($id) {
        $this->nivel = Session::get('nivel');
        $this->adulto = Load::model('usuarios')->find($id);

        // FIXME: Optimizar los parciales con la carga asincrono se puede hacer un sola función ya que comunicación 
        // las formas de los datos son exactamente las mismas (JS), prioridad -99
        if (Input::hasPost('adulto')) {
            Load::model('usuarios');
            $datos = Input::post('adulto');
            $usuario = new Usuarios();
            if ( $usuario->actualizar($datos) ) {
                Flash::valid('Usuario actualizado exitosamente!!!');
                Router::redirect('usuarios/');
            }
        }
    }

    public function borrar() {
        if ( Input::hasPost('type') ) {
            $id = Input::post('id');
            if ( Load::model('usuarios')->cambiar_estado($id, 3) ) Flash::success('Usuario borrado exitosamente');
        } else {
            Flash::error('Problemas al intentar borrar');
        }
    }

    public function desactivar() {
        if ( Input::hasPost('type') ) {
            $id = Input::post('id');
            if ( Load::model('usuarios')->cambiar_estado($id, '0') ) Flash::success('Usuario desactivado exitosamente');
        } else {
            Flash::error('Problemas al intentar borrar');
        }
    }

    public function activar() {
        if ( Input::hasPost('type') ) {
            $id = Input::post('id');
            if ( Load::model('usuarios')->cambiar_estado($id, 1) ) Flash::success('Usuario activado exitosamente');
        } else {
            Flash::error('Problemas al intentar borrar');
        }
    }

}
?>