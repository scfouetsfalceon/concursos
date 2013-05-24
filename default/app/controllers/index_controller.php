<?php
/**
 * Controlador por defecto si no se usa el routes
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
                $this->auth = new Auth('model', 'class: usuarios', "email: $usuario", "clave: $clave");
                if ( !$this->auth->authenticate() ) {
                    Flash::error("Usuario o Contraseña es Invalida");
                    $this->log->insert('0');
                } elseif( $this->auth->get('estatus') == 0 ) {
                    Auth::destroy_identity();
                    Session::delete('id');
                    Session::delete('nivel');
                    Session::delete('estructura');
                    Flash::info('Su cuenta esta inactiva');
                    Router::redirect('/');
                } elseif( $this->auth->get('estatus') == 2 ) {
                    Flash::info('Debe cambiar su contraseña');
                    Input::delete();
                    Router::redirect('cambio/');
                } else {
                    Session::set( 'id', $this->auth->get('id') );
                    Session::set( 'nivel', $this->auth->get('nivel'));
                    Session::set( 'estructura', $this->auth->get('estructura_id'));
                    Router::redirect('dashboard/');
                    $this->log->insert('1');
                }
            }  elseif ( Auth::is_valid() ) {
                    Router::redirect('dashboard/');
            }
        // } catch (Exception $exception) {
        //  Flash::error("Error Desconocido<br/>Consulte con el administrador");
        // }
    }

    public function dashboard() {
        // if( $this->auth->get('estatus') == 3 ) {
        //     Router::redirect('bienvenida/');
        // }
    }

    public function bienvenida() {
        $this->title = "Bienvenido al Sistema en línea de Concursos Nacionales";
    }

    public function cambio() {
        View::template('login');
        if (Input::hasPost('actual')) {
            $actual = md5(Input::post('actual'));
            $clave = Input::post('clave');
            $reclave = Input::post('reclave');

            $usuario = Load::model('usuarios');
            if ($usuario->verificar_clave($actual)) {
                if ($clave == $reclave && $clave != $actual) {
                    $usuario->cambio_clave(md5($clave));
                    Auth::destroy_identity();
                    Session::delete('id');
                    Session::delete('nivel');
                    Session::delete('estructura');
                    Flash::info('Clave cambiada exitosamente!!!');
                    Router::redirect('/');
                } else {
                    Flash::error('Las contraseñas no coinciden');
                    Input::delete();
                }
            } else {
                Flash::error('Contraseña Inválida');
                Router::redirect('salir/');
            }
        }
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
