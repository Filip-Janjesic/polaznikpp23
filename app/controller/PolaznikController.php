<?php

class PolaznikController extends AutorizacijaController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 
    'polaznik' . DIRECTORY_SEPARATOR;

    private $polaznik;
    private $poruka;

    public function index()
    {
        if(!isset($_GET['stranica'])){
            $stranica=1;
        }else{
            $stranica=(int)$_GET['stranica'];
        }
        if($stranica===0){
            $stranica=1;
        }

        if(!isset($_GET['uvjet'])){
            $uvjet='';
        }else{
            $uvjet= $_GET['uvjet'];
        }
      

        $ukupnoPolaznika = Polaznik::ukupnoPolaznika($uvjet);
        $ukupnoStranica = ceil($ukupnoPolaznika/App::config('rezultataPoStranici'));

        if($stranica>$ukupnoStranica){
            $stranica=$ukupnoStranica;
        }

        $this->view->render($this->viewDir . 'index',[
            'polaznici'=>Polaznik::read($stranica,$uvjet),
            'stranica' => $stranica,
            'uvjet' => $uvjet
        ]);
    }

    public function detalji($sifra = 0)
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            if($sifra==0){
                //novi polaznik
                $this->polaznik = new StdClass();
                $this->polaznik->ime='';
                $this->polaznik->prezime='';
                $this->polaznik->oib='';
                $this->polaznik->email='';
                $this->polaznik->brojugovora='';
                $this->poruka='Popunite tražene podatke';
                $akcija='Dodaj';
            }else{
                //postojeći
                $this->polaznik = Polaznik::readOne($sifra);
                $this->poruka='Promjenite željene podatke';
                $akcija='Promjeni';
            }
            $this->view->render($this->viewDir . 'detalji',[
                'polaznik' => $this->polaznik,
                'poruka' => $this->poruka,
                'akcija' => $akcija
            ]);
        }else{
            //post što znači kontrole, ostanak ili spremanje u bazu i povratak na index
            if($sifra==0){
                Polaznik::create($_POST);
            }else{
                Polaznik::update($sifra,$_POST);
            }
            $this->index();
        }
    }

    public function brisanje($sifra = 0){
        if($sifra==0){
            $this->index();
            return;
        }
        Polaznik::delete($sifra);
        $this->index();
    }

    public function trazipolaznike()
    {
        header('Content-type: application/json');
        echo json_encode(Polaznik::trazipolaznike($_GET['uvjet'],$_GET['grupa']));
    }
}