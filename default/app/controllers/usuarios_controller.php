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
        // print_r($this->lista);
    }

    public function nuevo() {
        $this->nivel = Session::get('nivel');

        if (Input::hasPost('adulto')) {
            Load::model('usuarios');
            $usuario = new Usuarios(Input::post('adulto'));
            if ( $usuario->guardar() ) {
                Flash::valid('Usuario creado existosamente!!!');
                Router::redirect('usuarios/');
            }
        }
    }

}
?>