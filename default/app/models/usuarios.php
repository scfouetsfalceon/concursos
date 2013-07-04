<?php

class Usuarios extends ActiveRecord {
	protected $logger = True;

	public function listar($nivel, $estructura) {
		$columns = 'columns: primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, email, estado, nivel';
		$conditions = "`nivel` >= '$nivel' AND `estructura_id` = '$estructura'";
		return $this->find($columns, $conditions);
	}

	public function verificar_clave($clave_actual){
		$usuario = $this->find_first(Auth::get('id'));
		return ($usuario->clave == $clave_actual)?True:False;
	}

	public function cambio_clave($clave_nueva, $estado=1){
		$usuario = $this->find_first(Auth::get('id'));
		$usuario->clave = $clave_nueva;
		$usuario->estado = $estado;
		return ($usuario->update())?True:False;
	}

	public function temporal_clave() {
		return $this->cambio_clave($clave_nueva, 2);
	}

	public function cambiar_estado() {
		$usuario = $this->find_first(Auth::get('id'));
		$usuario->estado = $estado;
		return ($usuario->update())?True:False;
	}

	public function getDatos() {
		$usuario = $this->find_first(Session::get('id'));
		return ($usuario)?$usuario:False;
	}
}

?>