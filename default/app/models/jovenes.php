<?php

class Jovenes extends ActiveRecord {
	protected $logger = True;

	public function insertar() {
		$this->nacionalidad = ($this->nacionalidad == 'VENEZOLANA' || $this->nacionalidad == 'V')?'V':'E';
		$this->estado = 1;
		return ($this->create())?True:False;
	}

	public function actualizar() {
		$this->estado = 1;
		return ($this->update())?True:False;
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