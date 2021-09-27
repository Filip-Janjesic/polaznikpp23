<?php

class PredavacController extends AutorizacijaController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 
    'predavac' . DIRECTORY_SEPARATOR;

    private $predavac;
    private $poruka;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'predavaci'=>Predavac::read()
        ]);
    }

    public function detalji($sifra = 0)
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            if($sifra==0){
                //novi predavač
                $this->predavac = new StdClass();
                $this->predavac->ime='';
                $this->predavac->prezime='';
                $this->predavac->oib='';
                $this->predavac->email='';
                $this->predavac->iban='';
                $this->poruka='Popunite tražene podatke';
                $akcija='Dodaj';
            }else{
                //postojeći
                $this->predavac = Predavac::readOne($sifra);
                $this->poruka='Promjenite željene podatke';
                $akcija='Promjeni';
            }
            $this->view->render($this->viewDir . 'detalji',[
                'predavac' => $this->predavac,
                'poruka' => $this->poruka,
                'akcija' => $akcija
            ]);
        }else{
            //post što znači kontrole, ostanak ili spremanje u bazu i povratak na index
            if($sifra==0){
                Predavac::create($_POST);
            }else{
                Predavac::update($sifra,$_POST);
            }
            $this->index();
        }
    }

    public function brisanje($sifra = 0){
        if($sifra==0){
            $this->index();
            return;
        }
        Predavac::delete($sifra);
        $this->index();
    }
}