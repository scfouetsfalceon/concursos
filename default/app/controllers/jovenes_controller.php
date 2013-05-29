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
				$salida = array('status' => 'ERROR');
				try{
					$jovenes = new Jovenes(Input::post('registro'));
					if ( $jovenes->insertar() ) {
						$salida['salida'] = 'OK';
					} else {
						$salida['message'] = 'Error durante el registro del Jóven - Intente más tarde';
					}
				} catch (Exception $e) {
					print_r($e);
					$salida['message'] = 'Error durante el registro del Jóven - Intente más tarde';
				}
				echo json_encode($salida);
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