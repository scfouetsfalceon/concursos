<?php

class Jovenes extends ActiveRecord {
	protected $logger = True;

	public function initialize() {
		$this->validates_presence_of('primer_nombre', 'message: Es obligatorio el primer nombre');
		$this->validates_presence_of('primer_apellido', 'message: Es obligatorio el primer apellido');
		$this->validates_presence_of('ramas_id', 'message: Debe seleccionar una Unidad');
		$this->validates_uniqueness_of('credencial', 'message: Por favor verifique, existe alguien registrado con esa credencial');
	}

	public function insertar($data) {
        $this->dump_result_self($data);
		$this->nacionalidad = ($this->nacionalidad == 'VENEZOLANA' || $this->nacionalidad == 'V')?'V':'E';
        if ( $this->exists("nacionalidad = '$this->nacionalidad' AND cedula = '$this->cedula'") ){
            Flash::error('Ya existe un jovén con esa cédula');
            return False;
        }
		$this->estado = 1;
		return ($this->create())?True:False;
	}

	public function actualizar($data) {
        $this->find_first($data['id']);
        $this->dump_result_self($data);
		return ( $this->update() )?True:False;
	}

	public function listar($rama){
		$columns = 'columns: jovenes.id, credencial, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, nombre';
		$joins = 'join: INNER JOIN  `ramas` ON `ramas`.`id` = `jovenes`.`ramas_id` INNER JOIN `tipo` ON `tipo`.`id` = `tipo_id`';
		$condition = "conditions: ramas_id = $rama AND estado = 1";
		return $this->find($columns, $joins,$condition);
	}
    public function listarAct($rama){
        $columns = 'columns: jovenes.id, credencial, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, nombre, jovenes_actividades.actividades_id';
        $joins = 'join: INNER JOIN  `ramas` ON `ramas`.`id` = `jovenes`.`ramas_id` INNER JOIN `tipo` ON `tipo`.`id` = `tipo_id` LEFT JOIN jovenes_actividades ON jovenes.id = jovenes_actividades.jovenes_id';
        $condition = "conditions: ramas_id = $rama AND estado = 1";
        return $this->find($condition, $columns, $joins);
    }

	public function borrar($id) {
        if ( date('n') > 3 ) {
            Flash::error('Operación Inválida, no puede eliminar a un jovén fuera de época de registro');
            return False;
        }
        $joven = $this->find_first($id);
        $joven->estado = 2;
        return ($joven->update())?True:False; // Borrado lógico
	}

    public function consultar($id) {
        $columns = "columns: credencial, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, nacionalidad, cedula";
        return $this->find_first($id, $columns);
    }
}

?>