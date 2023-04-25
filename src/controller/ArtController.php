<?php

namespace  src\controller;


class ArtController   {

    protected  $viewPath;
    protected $template;

    public function render($view , $variables) {

        ob_start();
        extract($variables);

        require($this -> viewpath. str_replace('.','\',$view).'.php');

        $content = ob_get_clean();
        require($this -> viewPath.'templates/'. $this -> template . '.php');
    }
}
