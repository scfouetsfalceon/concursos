<?php

class ReportarController extends AppController {

    public function index($param1) {
        $nivel = (isset($param1) && Session::get('nivel') < $param1)?$param1:Session::get('nivel');
    }

    public function estructura() {
        
    }

}

?>