<?php

class Jovenes extends ActiveRecord {
	protected $logger = True;

	public function initialize() {
		$this->validates_presence_of('primer_nombre', 'message: Es obligatorio el primer nombre');
		$this->validates_presence_of('primer_apellido', 'message: Es obligatorio el primer apellido');
		$this->validates_presence_of('ramas_id', 'message: Debe seleccionar una Unidad');
		$this->validates_uniqueness_of('credencial', 'message: Por favor verifique, existe alguien registrado con esa credencial');
	}

	public function insertar() {
		$this->nacionalidad = ($this->nacionalidad == 'VENEZOLANA' || $this->nacionalidad == 'V')?'V':'E';
		$this->estado = 1;
		return ($this->create())?True:False;
	}

	public function actualizar() {
		$this->estado = 1;
		return ($this->update())?True:False;
	}

	public function listar(){

	}

	private function cambiar_estado($id, $estado) {
		$joven = $this->find_first($id);
		$joven->estado = $estado;
		return ($this->update())?True:False;
	}

	public function borrar($id) {
		return $this->cambiar_estado($id, 2); // Borrado lógico
	}

	public function inactivar($id){
		return $this->cambiar_estado($id, 0);
	}

	public function activar($id) {
		return $this->cambiar_estado($id, 1);
	}
}

?>