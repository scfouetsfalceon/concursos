<?php

class grupos extends ActiveRecord {
	protected $logger = True;

	public function listar($distrito) {
		return $this->find('distrito_id = '.$distrito);
	}
}

?>