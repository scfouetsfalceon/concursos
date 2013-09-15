<?php

/**
*
*/
class ActividadesController extends AppController
{
    public $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    private $sabados = 6;
    private $segundos_dias = 86400;



	public function index($param1=null, $param2=null, $param3=null) {
        $ano_actual = date('Y', $this->hoy);
        $nivel = (isset($param1) && Session::get('nivel') < $param1)?$param1:Session::get('nivel');
        $estructura = ( (Session::get('nivel') == $nivel) && (Session::get('estructura') != $param2) )?Session::get('estructura'):$param2;
        $ano = ($ano_actual < $param3)?$ano_actual:$param3;
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

    public function unidad($param1=null, $param2=null) {

        $this->id = (Session::get('nivel') == 5)?Session::get('estructura'):$param1;

        $ano_actual = date('Y', $this->hoy);
        $this->mes_actual = date('n', $this->hoy);

        $ano = ( !isset($param2) || $ano_actual < $param2 )? $ano_actual : $param2;

        $primer_dia   = $ano."-01-01";
        $ultimo_dia     = $ano."-12-31";
        #timezone_open('America/Caracas');
        $fecha_inicio      = strtotime($primer_dia);
        $fecha_fin        = strtotime($ultimo_dia);
        $n = 1;
        $meses = $this->meses;

        $this->objeto = new StdClass();
        $fechas = Load::model('actividades');

        $hay = False;
        for($dia = $fecha_inicio; $dia <= $fecha_fin; $dia += $this->segundos_dias){
            if(date("d", $dia) == "01") {
                $act = $fechas->listar($this->id, $ano, date('m',$dia));
                if( count($act) ) {
                    $this->objeto->$meses[date('n',$dia)-1] = $act;
                    $hay = True;
                } else {
                    $this->objeto->$meses[date('n',$dia)-1] = array();
                    $hay = False;
                }
            }
        }

	}

	public function mes($unidad, $mes=null, $ano=null) {
        $this->unidad = $unidad;
        $mes_actual = date('n', $this->hoy);
        $ano_actual = date('Y', $this->hoy);
        // if ( $mes < $mes_actual-3 ) {
        //     Flash::error('No se pueden reportar una actividad con más de 3 meses de realizada!!!');
        //     Router::toAction("unidad/$unidad/");
        // }
        $this->mes = ( !isset($mes) || $mes_actual < $mes )? $mes_actual : $mes;
        $this->mes = ($this->mes < 10)?'0'.$this->mes:$this->mes; // Agregamos el cero(0) al mes
        $this->ano = ( !isset($ano) || $ano_actual < $ano)? $ano_actual : $ano;

        $act = Load::model('actividades')->listar($this->unidad, $this->ano, $this->mes);
        if( count($act) ) {
            foreach ($act as $dia) {
                $fecha = explode('-', $dia->fecha);
                $dia->fecha = $fecha[2].'/'.$fecha[1].'/'.$fecha[0];
                $dia->creditos = Toolkit::calcularCreditos($dia->duracion, $dia->bcp, $dia->ba, $dia->bgi);
            }
            $this->dias = $act;
        } else {
            // Primer día de cada mes
            $primer_dia = '01-'.$this->mes.'-'.$this->ano;
            $fecha_inicio = strtotime($primer_dia);


            // Obtenemos el útilmo día del mes
            $ultimo_dia = date('t', $fecha_inicio).'-'.$this->mes.'-'.$this->ano;
            $fecha_fin = strtotime($ultimo_dia);

            $this->dias = array();
            $objeto = new StdClass();
            $objeto->id = null;
            $objeto->fecha = null;
            $objeto->nombre = null;
            $objeto->lugar = null;
            $objeto->duracion = null;
            $objeto->cval = null;
            $objeto->cac = null;
            $objeto->bcp = null;
            $objeto->ba = null;
            $objeto->bgi = null;
            $objeto->creditos = null;

            $i=0;
            for($dia = $fecha_inicio; $dia <= $fecha_fin; $dia += $this->segundos_dias){
                if (date("w", $dia) == $this->sabados) {
                    $this->dias[$i]= clone $objeto;
                    $this->dias[$i]->fecha = date("d/m/Y",$dia);
                    $i++;
                }
            }
        }
	}

    public function crear() {
        if (Input::hasPost('actividad')) {
            $rama = Input::post('rama');
            $actividades = Input::post('actividad');
            $modelo = Load::model('actividades');
            print_r($actividades);
            $resultado = True;
            foreach ($actividades as $actividad) {
                if ( !empty($actividad['nombre']) && $actividad['duracion'] != '' ){
                    $resultado = $resultado && $modelo->nueva($rama, $actividad);
                }
            }
            if($resultado) Flash::success('Actividades registradas exitosamente!!!');
        }
        Router::redirect('actividades/unidad/'.$rama);
    }
}

?>