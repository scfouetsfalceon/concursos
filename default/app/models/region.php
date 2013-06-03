<?php

class region extends ActiveRecord {
	protected $logger =  True;

	public function listar() {
		return $this->find();
	}
}

?>