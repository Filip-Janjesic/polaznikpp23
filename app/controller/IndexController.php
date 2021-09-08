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
        if(Request::isAutoriziran()){
            $np = new NadzornaplocaController();
            $np->index();
            return;
        }
        $this->loginView('','Unesite tražene podatke');
    }

    public function logout()
    {
        unset($_SESSION['autoriziran']);
        session_destroy();
        $this->index();
    }

    public function autorizacija()
    {

        if(!isset($_POST['email']) || !isset($_POST['lozinka'])){
            $this->login();
            return; //short curcuiting
        }

        // ovdje znamo da su email i lozinka postavljeni
        if(strlen(trim($_POST['email']))===0){
            $this->loginView('','Email obavezno');
            return;
        }

        if(strlen(trim($_POST['lozinka']))===0){
            $this->loginView($_POST['email'],'Lozinka obavezno');
            return;
        }

        // svi podaci za provjeru u bazi su dobri
        $operater = Operater::autoriziraj($_POST['email'],$_POST['lozinka']);
        if($operater==null){
            $this->loginView($_POST['email'],'Kombinacija email i lozinka netočna');
            return;
        }

        //ovdje znam da je operater logiran
        $_SESSION['autoriziran']=$operater;
        $np = new NadzornaplocaController();
        $np->index();

    }

    private function loginView($email,$poruka)
    {
        $this->view->render('login',[
            'email'=>$email,
            'poruka'=>$poruka
        ]);
    }
   
}