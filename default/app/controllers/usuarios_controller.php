<?php

/**
* 
*/
class UsuariosController extends AppController
{
    
    public function index() {
        $nivel = Session::get('nivel');
        $estructura = Session::get('estructura');

        $this->lista = Load::model('usuarios')->listar($nivel, $estructura);
    }

}
?>