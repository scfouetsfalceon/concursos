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
			if($type=='json'){
				View::template(null);
				View::reponse('json');
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