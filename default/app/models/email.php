<?php

/**
*
*/

Load::lib('phpmailer/class.phpmailer');

class email extends PHPMailer
{

    function __construct()
    {
        $this->setFrom('concurso@scoutsvenezuela.org.ve', 'Concursos Nacionales');
        $this->addAddress('jampgold@gmail.com', 'Jaro Marval');
    }

    function AdministradorEliminar($id, $who, $Subject) {
        $this->Body = "ID a eliminar $id, solicitud hecha por $who";
        $this->Subject = "Solicitud de Eliminacion para $Subject";
        if (!$this->send()) {
            Flash::error("Error " . $this->ErrorInfo);
        } else {
            Flash::valid("Solicitud para eliminar ha sido enviada al administrador y será atendido en la brevedad posible");
        }
    }

    function SolicitudSoporte($title, $message){
        $datos = Load::model('usuarios')->getDatos();
        $this->addReplyTo("$datos->email", "$datos->primer_nombre $datos->primer_apellido");
        $this->addAddress('ppjj@scoutsfalcon.org', 'Programa de Jovénes Falcón');
        $meta = '<b>Sctr. '.trim($datos->primer_nombre.' '.$datos->segundo_nombre).' '.trim($datos->primer_apellido.' '.$datos->segundo_apellido).'</b><br>';
        $meta = '<b>Región: </b>'.(empty($datos->region_nombre))?$datos->region_nombre:'No Aplica'.'<br>';
        $meta = (empty($datos->distrito_nombre))?'<b>Distrito: </b>'.$datos->region_nombre.'<br>':'';
        $meta = (empty($datos->_nombre))?'<b>Grupo: </b>'.$datos->region_nombre.'<br>':'';
        $meta = (empty($datos->region_nombre))?'<b>Rama: </b>'.$datos->region_nombre.'<br><br>':'';

        $this->Body = $meta.$message;
        $this->Subject = "[Soporte] ".$title;
        if (!$this->send()) {
            Flash::error("Error " . $this->ErrorInfo);
        } else {
            Flash::valid("Solicitud de soporte enviada éxitosamente!!!");
        }
    }
}

?>