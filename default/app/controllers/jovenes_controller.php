<?php

class JovenesController extends AppController {

	/**
	 * Listar Jóvenes registrados dentro del sistema
	 */
	public function index($rama=null) {
		$this->lista = null;
		$this->rama = $rama;
		if ( !isset($this->rama) ) { // Session::get('nivel') != 5 ) {
			Router::redirect('estructura/');
		} else {
			$this->registro = (date('n', $this->hoy) <= 3)?True:False;
			$this->lista = Load::model('jovenes')->listar($this->rama);
		}
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