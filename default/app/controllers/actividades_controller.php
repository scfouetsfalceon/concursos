<?php

/**
* 
*/
class ActividadesController extends AppController
{
	
	public function index($param=null) {

        $hoy = $_SERVER['REQUEST_TIME'];
        $ano_actual = date('Y', $hoy);
        $this->mes_actual = date('n', $hoy);
        $sabados = 6;
        $segundos_dias = 86400;

        $ano = ( !isset($param) || $ano_actual < $param )? $ano_actual : $param;

        $primer_dia   = $ano."-01-01";
        $ultimo_dia     = $ano."-12-31";
        #timezone_open('America/Caracas');
        $fecha_inicio      = strtotime($primer_dia);
        $fecha_fin        = strtotime($ultimo_dia);
        $n = 1;

        $this->objeto = new StdClass();
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        for($dia = $fecha_inicio; $dia <= $fecha_fin; $dia += $segundos_dias){
            if(date("d", $dia) == "01") {
                // echo date("F",$dia)."\n";
                $this->objeto->$meses[date('n',$dia)-1] = array();
            }
            if (date("w", $dia) == $sabados) {
                // echo $n." -> ". date_format($dia,"d/m/Y")."\n";
                // echo date("d/m/Y",$dia)."\n";
                array_push($this->objeto->$meses[date('n',$dia)-1], date("d/m/Y",$dia));
            }
        }

	}

	public function nueva() {

	}
}

?>