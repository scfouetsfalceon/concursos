<?php

class distrito extends ActiveRecord {
	protected $logger =  True;

	public function listar($region) {
		return $this->find('region_id = '.$region);
	}
}

?>