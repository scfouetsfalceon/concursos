<?php

/**
*
*/
class ActividadesController extends AppController
{
    public $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    private $sabados = 6;
    private $segundos_dias = 86400;



	public function index($param1=null, $param2=null) {

    }

    public function unidad($param1=null, $param2=null) {

        $this->id = (Session::get('nivel') == 5)?Session::get('nivel'):1;

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

        for($dia = $fecha_inicio; $dia <= $fecha_fin; $dia += $this->segundos_dias){
            if(date("d", $dia) == "01") {
                $this->objeto->$meses[date('n',$dia)-1] = array();
            }
            if (date("w", $dia) == $this->sabados) {
                array_push($this->objeto->$meses[date('n',$dia)-1], date("d/m/Y",$dia));
            }
        }

	}

	public function nueva($unidad, $mes=null, $ano=null) {
        $this->unidad = $unidad;
        $mes_actual = date('n', $this->hoy);
        $ano_actual = date('Y', $this->hoy);
        $this->mes = ( !isset($mes) || $mes_actual < $mes )? $mes_actual : $mes;
        $this->ano = ( !isset($ano) || $ano_actual < $ano)? $ano_actual : $ano;

        $m = ($this->mes > 9)?'0'.$this->mes:$this->mes;
        $primer_dia = '01-'.$m.'-'.$this->ano;
        $fecha_inicio = strtotime($primer_dia);

        $ultimo_mes = date('t', $fecha_inicio);
        $ultimo_dia = $ultimo_mes.'-'.$m.'-'.$this->ano;
        $fecha_fin = strtotime($ultimo_dia);

        $this->dias = array();
        for($dia = $fecha_inicio; $dia <= $fecha_fin; $dia += $this->segundos_dias){
            if (date("w", $dia) == $this->sabados) {
                $this->dias[] = date("d/m/Y",$dia);
            }
        }
	}

    public function crear() {
        if (Input::hasPost('actividad')) {
            $rama = Input::post('rama');
            $actividades = Input::post('actividad');
            $resultado = True;
            foreach ($actividades as $actividad) {
                if ( !empty($actividad['actividad']) && !empty($actividad['duracion']) ){
                    $resultado = $resultado && Load::model('actividades')->nueva($rama, $actividad['fecha'], $actividad['actividad'], $actividad['lugar'], $actividad['tipo'], $actividad['duracion'], $actividad['bcp'], $actividad['ba'], $actividad['bgi']);
                }
            }
            if($resultado) Flash::success('Actividades registradas exitosamente!!!');
        }
        Router::redirect('actividades/unidad/');
    }
}

?>