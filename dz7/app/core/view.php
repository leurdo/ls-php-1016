<?php

class View {

    private $twig;

    function __construct()
    {
        $loader = new Twig_Loader_Filesystem(dirname(__DIR__).'/views/twig');
        $twig = new Twig_Environment($loader, array(
            'cache' => dirname(__DIR__).'/cache'
        ));
        $this->twig = $twig;
    }

    function generate($content_view, $data = null){
        echo $this->twig->render($content_view, $data);
    }

}