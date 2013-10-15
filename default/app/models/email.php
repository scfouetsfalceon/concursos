<?php

/**
*
*/

Load::lib('phpmailer/class.phpmailer');

class email extends PHPMailer
{

    function __construct()
    {
        //Set who the message is to be sent from
        $this->setFrom('concurso@scoutsvenezuela.org.ve', 'Concursos Nacionales');
        //Set who the message is to be sent to
        $this->addAddress('jampgold@gmail.com', 'Jaro Marval');
    }

    function AdministradorEliminar($id, $who, $Subject) {
        $this->Body = "ID a eliminar $id, solicitud hecha por $who";
        $this->Subject = 'Solicitud de Eliminación para $Subject';
        //send the message, check for errors
        if (!$this->send()) {
            Flash::error("Error " . $this->ErrorInfo);
        } else {
            Flash::valid("Solicitud para eliminar ha sido enviada al administrador y será atendido en la brevedad posible");
        }
    }
}

?>