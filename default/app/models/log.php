<?php
/**
 * Modelo para llevar registro movimiento de usuarios
 * (login, logout, session_closed)
 * @package models
 * @author Jaro Marval <jampgold@gmail.com>
 * @version 1.0
 * @todo crear funcion que banee usuarios
 *
 */
class Log extends ActiveRecord{
    protected $logger = True;

	public function insert($action) {
		$this->usuario_id = Session::get('id');
		$this->ip = Utils::getIp();
		$this->accion = $action;
		$this->save();
	}

    public function ultimaVisita(){
        return $this->find_first('usuario_id = '.Session::get('id'), 'columns: creado_at', 'order: id DESC')->fecha;
    }

}

?>