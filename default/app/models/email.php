<?php

/**
*
*/
Load::lib('phpmailer/PHPMailerAutoload');
// Load::lib('phpmailer/class.stmp');

class email extends PHPMailer
{

    function __construct()
    {
        $this->CharSet = 'UTF-8'; // Solución del problema con los acentos
        $this->setFrom('concursos.nacionales@scoutsvenezuela.org.ve', 'Concursos Nacionales');
        $this->addAddress('jampgold@gmail.com', 'Jaro Marval'); // Sin importar que pase siempre enviame un correo
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
        $this->addAddress('concursos.nacionales@scoutsvenezuela.org.ve', 'Concursos Nacionales');
        $meta = '<b>Sctr. '.trim($datos->primer_nombre.' '.$datos->segundo_nombre).' '.trim($datos->primer_apellido.' '.$datos->segundo_apellido).'</b><br>';
        $meta .= '<b>Región: </b>'.((!empty($datos->region_nombre))?$datos->region_nombre:'No Aplica').'<br>';
        $meta .= (!empty($datos->distrito_nombre))?'<b>Distrito: </b>'.$datos->distrito_nombre.'<br>':'';
        $meta .= (!empty($datos->grupos_nombre))?'<b>Grupo: </b>'.$datos->grupos_nombre.'<br>':'';
        $meta .= (!empty($datos->ramas_nombre))?'<b>Rama: </b>'.$datos->rama_snombre.'<br>':'';
        $meta .= '<br><b>Descripción:</b><br>';
        $this->msgHTML($meta.$message);
        $this->Subject = "[Soporte] ".$title;
        if (!$this->send()) {
            Flash::error("Error " . $this->ErrorInfo);
        } else {
            Flash::valid("Solicitud de soporte enviada éxitosamente!!!");
        }
    }
}

?>
