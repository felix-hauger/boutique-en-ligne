<?php


namespace  src\controller;

use src\controller\ArtController;


class  AppController extends  ArtController   {

    protected  $template = 'default';

    public function __ construct(){
        $this -> viewPath = ROOT.'/app/views/';
    }

    protected function loadModel($model_name){
        $this -> getTable($model_name);
    }
}