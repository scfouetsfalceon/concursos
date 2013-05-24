<?php

class Usuarios extends ActiveRecord {
	protected $logger = True;

	public function verificar_clave($clave_actual){
		$usuario = $this->find_first(Auth::get('id'));
		return ($usuario->clave == $clave_actual)?True:False;
	}

	public function cambio_clave($clave_nueva, $estatus=1){
		$usuario = $this->find_first(Auth::get('id'));
		$usuario->clave = $clave_nueva;
		$usuario->estatus = $estatus;
		return ($usuario->update())?True:False;
	}

	public function temporal_clave() {
		return $this->cambio_clave($clave_nueva, 2);
	}

	public function cambiar_estatus() {
		$usuario = $this->find_first(Auth::get('id'));
		$usuario->estatus = $estatus;
		return ($usuario->update())?True:False;
	}
}

?>