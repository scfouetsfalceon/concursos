<?php

class ramas extends ActiveRecord {
    protected $logger = True;

	public function getRamas($grupo=Null) {
		$grupo=(!isset($grupo))?Session::get('estructura'):$grupo;
		$columns="columns: ramas.id, nombre";
		$joins="join: INNER JOIN tipo ON tipo.id = ramas.tipo_id";
		return $this->find('conditions: grupos_id = '.$grupo,$columns,$joins);
	}

    public function nuevo($tipo, $grupo) {
        $this->tipo_id = $tipo;
        $this->grupos_id = $grupo;
        return $this->create();
    }
}

?>