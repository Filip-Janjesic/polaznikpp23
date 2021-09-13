<?php

class SmjerController extends AutorizacijaController
{

    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 
                        'smjer' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'smjerovi'=>Smjer::read()
        ]);
    }

    public function novi()
    {
        $this->view->render($this->viewDir . 'novi');
    }

    public function promjena()
    {
        $this->view->render($this->viewDir . 'promjena');
    }

    public function brisanje()
    {
       
    }
}