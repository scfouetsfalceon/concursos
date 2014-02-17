<?php

class JovenesController extends AppController {

    /**
     * Listar Jóvenes registrados dentro del sistema
     */
    public function index($rama=null) {
        $this->lista = null;
        $this->rama = $rama;
        if ( !isset($this->rama) ) { // Session::get('nivel') != 5 ) {
            Router::redirect('estructura/');
        } else {
            $this->registro = (date('n', $this->hoy) <= 3)?True:False;
            $this->lista = Load::model('jovenes')->listar($this->rama);
        }
    }

    /**
     * Registrar Joven dentro de sistema
     */
    public function registrar() {
        if(Input::hasPost('registrar')) {
            if(Input::post('type')=='json'){
                Load::model('jovenes');
                $data = Input::post('registro');
                $jovenes = new Jovenes();
                if ( !empty($data['id']) ){
                    // Flash::info('Actualizar');
                    if ( $jovenes->actualizar($data) ) {
                        Flash::valid('Jóven actualizado con éxito');
                    }
                } else {
                    // Flash::info('Nuevo');
                    if ( $jovenes->insertar($data) ) {
                        Flash::valid('Jóven registrado con éxito');
                    }
                }
            }
        }
    }

    public function borrar() {
        if(Input::post('type')=='json'){
            if ( Load::model('jovenes')->borrar(Input::post('id')) ) {
                Flash::valid('Jóven borrado con éxito');
            }
        }
    }

    public function consultar() {
        $id = Input::request('id');
        echo json_encode(Load::model('jovenes')->consultar($id));
    }

    public function migrar($id) {
        Load::model('jovenes')->migrar($id);
        Router::redirect(Utils::getBack());
    }
}

?>