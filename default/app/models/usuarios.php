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
        $conditions .= " AND estado != 3";
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

    public function cambiar_estado($id, $estado) {
        $usuario = $this->find_first($id);
        $usuario->estado = $estado;
        return ($usuario->update())?True:False;
    }

    public function getDatos() {
        $sql = "SELECT
        `usuarios`.`id`,
        `usuarios`.`primer_nombre`,
        `usuarios`.`segundo_nombre`,
        `usuarios`.`primer_apellido`,
        `usuarios`.`segundo_apellido`,
        `usuarios`.`nivel`,
        `usuarios`.`estructura_id`,
        `usuarios`.`region_id`,
        `region`.`nombre` AS region_nombre,
        `usuarios`.`distrito_id`,
        `distrito`.`nombre` AS distrito_nombre,
        `usuarios`.`distrito_id`,
        `distrito`.`nombre` AS distrito_nombre,
        `usuarios`.`grupos_id`,
        `grupos`.`nombre` AS grupos_nombre,
        `usuarios`.`ramas_id`,
        `tipo`.`nombre` AS ramas_nombre

        FROM `demo_concursos`.`usuarios`

        LEFT JOIN `region` ON `region`.`id` = `usuarios`.`region_id`
        LEFT JOIN `distrito` ON `distrito`.`id` = `usuarios`.`distrito_id`
        LEFT JOIN `grupos` ON `grupos`.`id` = `usuarios`.`grupos_id`
        LEFT JOIN `ramas` ON `ramas`.`id` = `usuarios`.`ramas_id`
        LEFT JOIN `tipo` ON `tipo`.`id` = `ramas`.`tipo_id`

        WHERE `usuarios`.`id` = ".Session::get('id');
        $usuario = $this->find_by_sql($sql);
        return ($usuario)?$usuario:False;
    }

    public function guardar() {
        $this->tipo = '0';
        $this->estado = 1;
        $this->clave = md5($this->clave);
        if ( empty($this->region_id) ) {
            $this->nivel = 1;
            $this->estructura_id = '0';
        } elseif ( $this->distrito_id == '0' || empty($this->distrito_id) ) {
            $this->nivel = 2;
            $this->estructura_id = $this->region_id;
        } elseif ( $this->grupos_id == '0' || empty($this->grupos_id) ) {
            $this->nivel = 3;
            $this->estructura_id = $this->distrito_id;
        } elseif ( $this->ramas_id == '0' || empty($this->ramas_id) ) {
            $this->nivel = 4;
            $this->estructura_id = $this->grupos_id;
        } else {
            $this->nivel = 5;
            $this->estructura_id = $this->ramas_id;
        }
        return $this->create();
    }

    public function actualizar($datos) {
        // print_r($this);

        $existe = $this->find_first($datos['id']);

        $existe->primer_nombre = $datos['primer_nombre'];
        $existe->segundo_nombre = $datos['segundo_nombre'];
        $existe->primer_apellido = $datos['primer_apellido'];
        $existe->segundo_apellido = $datos['segundo_apellido'];
        $existe->email = $datos['email'];

        if ( !empty($datos['clave']) ) {
            $existe->clave = md5($datos['clave']);
        }
        if ( empty($datos['region_id']) ) {
            $existe->nivel = 1;
            $existe->estructura_id = '0';
        } elseif ( empty($datos['distrito_id']) ) {
            $existe->nivel = 2;
            $existe->estructura_id = $datos['region_id'];
        } elseif ( empty($datos['grupos_id']) ) {
            $existe->nivel = 3;
            $existe->estructura_id = $datos['distrito_id'];
        } elseif ( empty($datos['ramas_id']) ) {
            $existe->nivel = 4;
            $existe->estructura_id = $datos['grupos_id'];
        } else {
            $existe->nivel = 5;
            $existe->estructura_id = $datos['ramas_id'];
        }

        $existe->tipo = '0';
        $existe->estado = 1;
        $existe->region_id = $datos['region_id'];
        $existe->distrito_id = $datos['distrito_id'];
        $existe->grupos_id = $datos['grupos_id'];
        $existe->ramas_id = $datos['ramas_id'];

        return $existe->update();
    }

}

?>