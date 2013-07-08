<?php

/**
*
*/
class RamasController extends AppController
{

    public function listar($param1, $param2=NULL) {
        if($param1 == 'json') {
            $id = Filter::get($param2, 'int');
        } else {
            $id = Filter::get($param1, 'int');
        }
        $lista = Load::model('ramas')->getRamas($id);
        if (count($lista) != 0) {
            $salida = array('status'=>'success', 'lista'=>$lista);
        } else {
            $salida = array('status'=>'error');
        }
        
        echo json_encode($salida);
    }

}

?>