<?php
/**
 * Controller por defecto si no se usa el routes
 *
 */
class IndexController extends AppController
{
    public function index()
    {
        View::template('login');
        // try {
            if (Input::post('usuario')) {
                Load::lib('auth');
                Load::lib('acl');
                Load::model('usuarios');
                $usuario = Input::post('usuario');
                $clave = md5(Input::post('clave'));
                $this->auth = new Auth('model', 'class: usuarios', "email: $usuario", "clave: $clave", "estatus: 1");
                if ( !$this->auth->authenticate() ) {
                    Flash::error("Usuario o Contrase&ntilde;a es Invalida");
                } else {
                    Session::set( 'id', $this->auth->get('id') );
                    Session::set( 'nivel', $this->auth->get('nivel'));
                    Session::set( 'estructura', $this->auth->get('estructura_id'));
                    Router::redirect('bienvenida/');
                }
            }  elseif ( Auth::is_valid() ) {
                    Router::redirect('bienvenida/');
            }
        // } catch (Exception $exception) {
        //  Flash::error("Error Desconocido<br/>Consulte con el administrador");
        // }
    }

    public function bienvenida() {
        $this->title = "Bienvenido al Sistema en línea de Concursos Nacionales";
    }

    public function salir() {
        Auth::destroy_identity();
        Session::delete('id');
        Session::delete('nivel');
        Session::delete('estructura');
        Flash::info('Sesión Cerrada');
        Router::redirect('/');
    }
}
