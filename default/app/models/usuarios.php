<?php

class Usuarios extends ActiveRecord {
	protected $logger = True;

	public function initialize(){
		$this->validates_uniqueness_of('cedula', 'message: Ya existe un usuario con esa cédula');
		$this->validates_uniqueness_of('credencial', 'message: Ya existe un usuario con esa credencial');
		$this->validates_uniqueness_of('email', 'message: Ya existe un usuario con ese Correo Electrónico');
	}

	public function listar($nivel, $estructura, $page) {
		$page = "page: ".$page;
		$per_page = "per_page: 10";
		if ($nivel <= 1) { // Creador o Nacional
			$conditions = "`nivel` != 0";
		} elseif ($nivel > 1) {
			$conditions = "(`nivel` = '$nivel' AND `estructura_id` = '$estructura')";
			if ( $nivel == 2 ) { // Regional
				$conditions .= " OR (`nivel` > '$nivel' AND `region_id` = '$estructura') ";
			} elseif ( $nivel == 3 ) { // Distrital
				$conditions .= " OR  (`nivel` > '$nivel' AND `distrito_id` = '$estructura') ";
			} elseif ( $nivel == 4 ) { // Grupo
				$conditions .= " OR  (`nivel` > '$nivel' AND `grupos_id` = '$estructura') ";
			} elseif ( $nivel == 5 ) { // Unidad
				$conditions .= " OR  (`nivel` > '$nivel' AND `unidad_id` = '$estructura') ";
			}
		}
		$columns = 'columns: id, cedula, nac, credencial, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, email, estado, nivel';
		return $this->paginate($columns, $conditions, $page, $per_page);
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

	public function guardar() {
		$this->tipo = '0';
		$this->estado = 1;
		$this->clave = md5($this->clave);
		if ( $this->region_id == '0' ) {
			$this->nivel = 1;
			$this->estructura_id = '0';
		} elseif ( $this->distrito_id == '0' ) {
			$this->nivel = 2;
			$this->estructura_id = $this->region_id;
		} elseif ( $this->grupos_id == '0' ) {
			$this->nivel = 3;
			$this->estructura_id = $this->distrito_id;
		} elseif ( $this->ramas_id == '0' ) {
			$this->nivel = 4;
			$this->estructura_id = $this->grupos_id;
		} else {
			$this->nivel = 5;
			$this->estructura_id = $this->ramas_id;
		}
		return $this->create();
	}

	public function actualizar($nueva) {
		print_r($this);
		$this->tipo = '0';
		$this->clave = (empty($nueva))?$this->clave:md5($nueva);
		if ( $this->region_id == '0' ) {
			$this->nivel = 1;
			$this->estructura_id = '0';
		} elseif ( $this->distrito_id == '0' ) {
			$this->nivel = 2;
			$this->estructura_id = $this->region_id;
		} elseif ( $this->grupos_id == '0' ) {
			$this->nivel = 3;
			$this->estructura_id = $this->distrito_id;
		} elseif ( $this->ramas_id == '0' ) {
			$this->nivel = 4;
			$this->estructura_id = $this->grupos_id;
		} else {
			$this->nivel = 5;
			$this->estructura_id = $this->ramas_id;
		}
		return $this->save();	
	}

}

?>