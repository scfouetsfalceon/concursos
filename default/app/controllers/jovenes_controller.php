<?php

class JovenesController extends AppController {

	/**
	 * Listar Jóvenes registrados dentro del sistema
	 */
	public function index() {

	}

	/**
	 * Registrar Joven dentro de sistema
	 */
	public function registrar($type='html') {
		if(Input::hasPost('registrar')) {
			if(Input::post('type')=='json'){
				Load::model('jovenes');
				$jovenes = new Jovenes(Input::post('registro'));
				if ( $jovenes->insertar() ) {
					Flash::valid('Jóven registrado con éxito');
				}
			}
		}

	}

	public function subir() {

	}

	public function importar() {

	}

	public function verificacion() {

	}
}

?>