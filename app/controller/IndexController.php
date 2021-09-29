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

        //https://www.php.net/manual/en/curl.examples.php
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, 'https://api.hnb.hr/tecajn/v2');

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);     

        $this->view->render('onama',[
            'lista'=>json_decode($output)
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

    public function test()
    {
        for($i=0;$i<1000;$i++){
            Polaznik::create([
                'ime'=>'Ime ' . $i,
                'prezime'=>'Prezime ' . $i,
                'email'=>'ime@prezime.com',
                'oib'=>'11111111111',
                'brojugovora'=>'2021/' . $i
            ]);
        }

    }

}