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

    public function login()
    {
        $this->view->render('login',[
            'poruka'=>'Unesite tražene podatke'
        ]);
    }

    public function autorizacija()
    {

        if(!isset($_POST['email']) || !isset($_POST['lozinka'])){
            $this->login();
            return;
        }

        if (strlen(trim($_POST['email']))===0){
            $this->view->render('login',[
                'poruka'=>'Unesite tražene podatke'
            ]);
            return;
        }

    }

}