<?php

/**
* Navegar por las estructuras desde nacional hasta las unidades
* Nacional > Regional > Distrital > Grupos > Unidades
*/
class EstructuraController extends AppController
{

    public function index($param1=null, $param2=null)
    {
        $this->nivel=(isset($param1))?$param1:Session::get('nivel');
        $this->estructura=(isset($param2))?$param2:Session::get('estructura');
        $this->lista = null;
        $this->ubicacion = 'Desconocida';

        switch ($this->nivel) {
            case 1: // Nacional
                echo "<h3>Regiones</h3>";
                $this->ubicacion = 'region';
                $this->lista = Load::model('region')->listar();
                break;
            case 2: // Regional
                echo "<h3>Distritos</h3>";
                $this->ubicacion = 'distrito';
                $this->lista = Load::model('distrito')->listar($this->estructura);
                break;
            case 3: // Distrital
                echo "<h3>Grupos</h3>";
                $this->ubicacion = 'grupo';
                $this->lista = Load::model('grupos')->listar($this->estructura);
                break;
            case 4: // Grupal
                echo "<h3>Unidades</h3>";
                $this->ubicacion = False;
                $this->lista = Load::model('ramas')->getRamas($this->estructura);
                break;
            case 5: // Unidades
                Router::redirect('jovenes/unidad/'.$this->estructura.'/');
                break;
        }
    }
}

?>