<?php

class ReportarController extends AppController {

    public function index($param1=null, $param2=null) {
        $nivel = (isset($param1) && Session::get('nivel') < $param1)?$param1:Session::get('nivel');
        $estructura = ( (Session::get('nivel') == $nivel) && (Session::get('estructura') != $param2) )?Session::get('estructura'):$param2;
        if ($nivel == 5) {
            Router::redirect('actividades/unidad/'.$estructura);
        } else {
            $this->nivel = $nivel;
            switch ($nivel) {
                case 1: // Nacional
                    echo "<h3>Regiones</h3>";
                    $this->lista = Load::model('region')->listarConActividades();
                    break;
                case 2: // Regional
                    echo "<h3>Distritos</h3>";
                    $this->lista = Load::model('distrito')->listarConActividades($estructura);
                    break;
                case 3: // Distrital
                    echo "<h3>Grupos</h3>";
                    $this->lista = Load::model('grupos')->listarConActividades($estructura );
                    break;
                case 4: // Grupal
                    echo "<h3>Unidades</h3>";
                    $this->lista = Load::model('ramas')->listarConActividades($estructura);
                    break;
            }
        }

    }

}

?>