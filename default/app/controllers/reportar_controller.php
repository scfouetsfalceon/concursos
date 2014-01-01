<?php

class ReportarController extends AppController {
    public $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    private $sabados = 6;
    private $segundos_dias = 86400;

    public function index($param1=null, $param2=null) {
        $nivel = (isset($param1) && Session::get('nivel') < $param1)?$param1:Session::get('nivel');
        $estructura = ( (Session::get('nivel') == $nivel) && (Session::get('estructura') != $param2) )?Session::get('estructura'):$param2;
        if ($nivel == 5) {
            Router::redirect('reportar/unidad/'.$estructura);
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

        $this->ano_actual = date('Y', $this->hoy);
        $this->mes_actual = date('n', $this->hoy);

        $ano = ( !isset($param2) || $this->ano_actual < $param2 )? $this->ano_actual : $param2;

        $primer_dia   = $ano."-01-01";
        $ultimo_dia     = $ano."-12-31";
        $fecha_inicio      = strtotime($primer_dia);
        $fecha_fin        = strtotime($ultimo_dia);
        $n = 1;
        $meses = $this->meses;

        $this->objeto = new StdClass();
        $fechas = Load::model('actividades');

        for($dia = $fecha_inicio; $dia <= $fecha_fin; $dia += $this->segundos_dias){
            if(date("d", $dia) == "01") {
                $act = $fechas->listar($this->id, $ano, date('m',$dia));
                if( count($act) ) {
                    $this->objeto->$meses[date('n',$dia)-1] = $act;
                } else {
                    $this->objeto->$meses[date('n',$dia)-1] = array();
                }
            }
        }

    }

    public function nuevo($param1=null, $param2=null, $param3=null) {
        $this->id = (Session::get('nivel') == 5)?Session::get('estructura'):$param1;
        $ano_actual = date('Y', $this->hoy);
        $mes_actual = date('m', $this->hoy);
        $this->mes = (empty($param2))?date('m', $this->hoy):$param2;

        if ( $ano_actual != 2013 && $this->mes < $mes_actual-3 ) {
            Flash::error('No se pueden reportar una actividad con más de 3 meses de realizada!!!');
            Router::toAction("unidad/$this->id/");
        }

        $this->mes = ($this->mes > 9)?$this->mes:'0'.$this->mes;

        $fechas = Load::model('actividades');
        $jovenes = Load::model('jovenes');

        $rama = Load::model('ramas')->buscar($this->id);
        if ( $rama->tipo_id == 1 || $rama->tipo_id == 2 ) {
            $this->rama = 12;
        } elseif ( $rama->tipo_id == 3 || $rama->tipo_id == 4 ) {
            $this->rama = 32;
        } else {
            $this->rama = 12;
        }

        $ano = ( !empty($param2) || $ano_actual < $param3 )? $ano_actual : $param3;

        $fecha = $fechas->listarSin($this->id, $ano, $this->mes);
        $this->objeto = array();
        $jovenes = $jovenes->listar($this->id);

        // Comenzando a armar un array de jovenes sobre la fecha y asistencia a las actividades
        $this->jovenes = array();
        $control  = "08/11/1984"; // Fecha de control(mi cumpleaños)
        $i=0; // Incremental para el número de actividades

        foreach ($fecha as $dia){
            // Para no crear 2 o más veces la fecha de la actividad y con ello sobreescribiendo la fecha
            if ($dia->id != $control) {
                $control = $dia->id;
                $this->objeto[$i]->fecha = Toolkit::fecha($dia->fecha);
                $this->objeto[$i]->nombre = $dia->nombre;
                $this->objeto[$i]->cval = $dia->cval;
                $this->objeto[$i]->cac = $dia->cac;
                $this->objeto[$i]->creditos = Toolkit::calcularCreditos($dia->duracion,$dia->bcp,$dia->ba,$dia->bgi);
                $this->objeto[$i]->reportado = empty($dia->jovenes_id)?0:1;
                $i++;
            }

            foreach ($jovenes as $item) {
                    if(!array_key_exists($item->id, $this->jovenes)) {
                        $this->jovenes[$item->id]['credencial'] = $item->credencial;
                        $this->jovenes[$item->id]['nombre'] = trim($item->primer_nombre.' '.$item->segundo_nombre)." ".trim($item->primer_apellido.' '.$item->segundo_apellido);
                        $this->jovenes[$item->id]['actividades'] = array();
                    }

                    if ( !@$this->jovenes[$item->id]['actividades'][$dia->id] ) {
                        $this->jovenes[$item->id]['actividades'][$dia->id] = array();
                        $this->jovenes[$item->id]['actividades'][$dia->id]['fecha'] = $dia->fecha;
                        $this->jovenes[$item->id]['actividades'][$dia->id]['creditos'] = Toolkit::calcularCreditos($dia->duracion,$dia->bcp,$dia->ba,$dia->bgi);
                        $this->jovenes[$item->id]['actividades'][$dia->id]['cval'] = $dia->cval;
                        $this->jovenes[$item->id]['actividades'][$dia->id]['cac'] = $dia->cac;
                        $this->jovenes[$item->id]['actividades'][$dia->id]['tipo'] = ($dia->cval==1)?'cval':'cac';
                        $this->jovenes[$item->id]['actividades'][$dia->id]['viejo'] = 2;
                    }

                    if ( empty($dia->jovenes_id) ) {
                        $this->jovenes[$item->id]['actividades'][$dia->id]['viejo'] = 0;
                    } elseif ( $dia->jovenes_id == $item->id ) {
                        $this->jovenes[$item->id]['actividades'][$dia->id]['viejo'] = 1;
                    }
            }
        }

        if ( Input::hasPost('registrar') ){
            $lista = Input::post('campo');
            if ( (bool)count($lista) ){
                $reporte = Load::model('jovenes_actividades');
                $control = array();
                $salida = True;

                foreach ($lista as $joven => $actividades) {
                    foreach ($actividades as $actividad) {
                        if(!in_array($actividad, $control)) array_push($control, $actividad);
                        $salida = $salida && $reporte->nuevo($joven, $actividad);
                    }
                }
                if ($salida) {
                    foreach ($control as $actividad) {
                        Load::model('actividades')->reportar($actividad);
                    }
                    Flash::valid('Actividades Reportadas con éxito');
                    Router::redirect('reportar/unidad/'.$this->id);
                }
            } else {
                Flash::info('Reporte vacío');
                Router::redirect('reportar/unidad/'.$this->id);
            }
        }
    }

    public function informe($param1=null, $param2=null) {
        $this->nivel = Session::get('nivel');
        $this->estructura = Session::get('estructura');
        $param1 = ( empty($param1) )?'':$param1.'/';
        $param2 = ( empty($param2) )?'':$param2.'/';
        if($this->nivel >= 5){
            Router::toAction('informe_unidad/'.$this->estructura.'/'.$param1.$param2);
        }
    }

    public function informe_unidad($unidad, $ano=null, $mes=null) {
        $ano_actual = date('Y', $this->hoy);
        $mes_actual = date('n', $this->hoy);
        $ano = ( !empty($ano) || $ano_actual < $ano )?$ano_actual:$ano;
        $mes = ( !empty($mes) || $mes_actual < $mes )?$mes_actual:$mes;
        $creditos = Load::model('jovenes_actividades')->jovenes($unidad, $ano, $mes);
        $rama = Load::model('ramas')->buscar($unidad);
        if ( $rama->tipo_id == 1 || $rama->tipo_id == 2 ) {
            $factor = 12;
        } elseif ( $rama->tipo_id == 3 || $rama->tipo_id == 4 ) {
            $factor = 32;
        } else {
            $factor = 12;
        }
        $this->jovenes = array();
        $cval = 0;
        $cac = 0;
        foreach ($creditos as $item) {
            if (!array_key_exists($item->id, $this->jovenes)) {
                $this->jovenes[$item->id] = array();
                $this->jovenes[$item->id]['credencial'] = $item->credencial;
                $this->jovenes[$item->id]['nombre'] = trim($item->primer_nombre.' '.$item->segundo_nombre).' '.trim($item->primer_apellido.' '.$item->segundo_apellido);
                $this->jovenes[$item->id]['cval'] = 0;
                $this->jovenes[$item->id]['cac'] = 0;
            }
            if ($item->cac == 1) {
                $cac += $item->creditos;
                $this->jovenes[$item->id]['cac'] += $item->creditos;
            }
            if ($item->cval == 1) {
                $cval += $item->creditos;
                $this->jovenes[$item->id]['cval'] += $item->creditos;
            }
        }
        $this->cval = round(($cval/$factor),0,PHP_ROUND_HALF_UP);
        $this->cac = round(($cac/$factor),0,PHP_ROUND_HALF_UP);
    }

    public function consulta($region=null, $distrito=null, $grupo=null){
        $mes=null; $ano=null;
        $ano_actual = date('Y', $this->hoy);
        $mes_actual = date('n', $this->hoy);
        $ano = ( !empty($ano) || $ano_actual < $ano )?$ano_actual:$ano;
        $mes = ( !empty($mes) || $mes_actual < $mes )?$mes_actual:$mes;

        $model = Load::model('jovenes_actividades');

        if(empty($region)) {
            $creditos = $model->nacional($ano, $mes);
        } elseif (empty($distrito)) {
            $creditos = $model->region($region, $ano, $mes);
        } elseif (empty($grupo)) {
            $creditos = $model->distrito($distrito, $ano, $mes);
        } else {
            $creditos = $model->grupo($grupo, $ano, $mes);
        }


        $indices = array(); // Array para almacenar los id de BBDD de la inserciones
        $index = 0; // Contador para los elementos introducidos en el array e indice para el nuevo array de objetos

        if ( count($creditos) != 0 ) {
            // Nuevo array de almacenar los datos de la consulta que luego van a ser convertidos en json
            $this->jovenes = array();
            foreach ($creditos as $item) {
                if( !in_array($item->id, $indices) ) {
                    array_push($indices, $item->id);
                    $this->jovenes[$index] = array();
                    $this->jovenes[$index]['id'] = $item->id;
                    $this->jovenes[$index]['campo'] = $item->campo;
                    $this->jovenes[$index]['campo_nombre'] = $item->campo_nombre;
                    $this->jovenes[$index]['cval'] = 0;
                    $this->jovenes[$index]['cac'] = 0;
                    $index++;
                }
                if ($item->cac == 1) {
                    $i = array_search($item->id, $indices);
                    $this->jovenes[$i]['cac'] += $item->creditos;
                }
                if ($item->cval == 1) {
                    $i = array_search($item->id, $indices);
                    $this->jovenes[$i]['cval'] += $item->creditos;
                }
            }
            $salida = array('status'=>'valid', 'jovenes'=>$this->jovenes);
        } else {
            $salida = array('status'=>'error');
        }

        // Solo es para pruebas para poder como queda el array armado, luego solo quedará un
        echo json_encode($salida);
    }

}

?>