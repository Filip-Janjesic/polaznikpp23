<?php

class IndexController extends Controller
{
    public function index()
    {
        $this->view->render('index');
    }

    public function onama()
    {
        //dovuče podatke iz baze
        //dovuče podatke s REST API
        //PRILAGODI PODATKE ako treba
        //proslijedi podatke na view
        $this->view->render('onama',[
            'ime'=>'Pero',
            'podaci' => [1,2,3,2,2,2,3]
        ]);
    }
}