<?php
/**
 * Controlador principal que heredan los controladores
 *
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 **/

/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

Load::lib('auth');
Load::lib('acl');
class AppController extends Controller {

	final protected function initialize()
	{
		$this->log=Load::model('log');
        if ( !Auth::is_valid() ) {
            if(!(Router::get('controller') == 'index' && Router::get('action') == 'index' )) {
                Router::redirect('/');
            }
        } else {
	        if(Input::request('type')=='json') {
				View::response('json', null);
				View::select('../generico/generico');
			}
        }
	}

	final protected function finalize()
	{
		if ( !isset($this->title) ) {
			$this->title = 'ASV - '. APP_NAME;
		} else {
			$this->title = $this->title . ' » ' . APP_NAME . ' - ASV';
		}
	}
}
