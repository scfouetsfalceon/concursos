<?php

/**
* Sección de ayudas generales del Sistema
*/
class AyudasController extends AppController
{

    public function index() {
        // Esto es controlador totalmente vacío
    }

    /**
     * Video tutoriales del Concurso
     */
    public function videos(){
        // $videos= array('qu-tNQmxl8E', '6mztvEEDQ8c', 'Ch1eaaX8s60', 'uKA41hm3Qxw', 'GA6SUcBOWXs', 'S1lItLIcmGk');
        // $image= "http://img.youtube.com/vi/".$videos[0]."/mqdefault.jpg"; // Como todas las minituras son iguales

        $image= "http://img.youtube.com/vi/qu-tNQmxl8E/mqdefault.jpg"; // Como todas las minituras son iguales
        $this->items = array(
            array('id'=>'qu-tNQmxl8E', 'title'=>'Como ingresar', 'image'=>$image),
            array('id'=>'6mztvEEDQ8c', 'title'=>'Como cargar los datos', 'image'=>$image),
            array('id'=>'Ch1eaaX8s60', 'title'=>'Como crear actividades', 'image'=>$image),
            array('id'=>'uKA41hm3Qxw', 'title'=>'Como reportar la asistencia', 'image'=>$image),
            array('id'=>'GA6SUcBOWXs', 'title'=>'Como ver el informe', 'image'=>$image),
            array('id'=>'S1lItLIcmGk', 'title'=>'Como crear usuarios', 'image'=>$image)
        );

    }

    public function soporte(){
        if(Input::hasPost('type')){
            Load::model('email');
            $email = new email();
            $email->SolicitudSoporte(Input::post('titulo'), Input::post('mensaje'));
        }
    }
}

?>