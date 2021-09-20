<?php

class SmjerController extends AutorizacijaController
{

    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 
                        'smjer' . DIRECTORY_SEPARATOR;
    private $smjer;
    private $poruka;

    public function __construct()
    {
        parent::__construct();
        $this->smjer = new stdClass();
        $this->smjer->naziv='';
        $this->smjer->cijena='0,00';
        $this->smjer->trajanje='100';
        $this->smjer->certifikat=true;
    }

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'smjerovi'=>Smjer::read()
        ]);
    }

    public function novi()
    {
        $this->view->render($this->viewDir . 'novi',[
            'smjer'=>$this->smjer,
            'poruka'=>'Popunite sve podatke'
        ]);
    }

    public function dodajnovi()
    {
        if(!$_POST){
           $this->novi();
           return;
        }

        $this->smjer = (object)$_POST;


        if(
            
            $this->kontrolaNaziv() 
        && $this->kontrolaTrajanje()
        && $this->kontrolaCijena()
        && $this->kontrolaCertifikat()
        
        ){
            //ide spremanje u bazu
            $this->smjer->cijena = str_replace(array('.', ','), array('', '.'), 
            $this->smjer->cijena);
            Smjer::create((array)($this->smjer));
            $this->index();
        }else{
            $this->view->render($this->viewDir . 'novi',[
                'smjer'=>$this->smjer,
                'poruka'=>$this->poruka
            ]); 
        }
    }

    private function kontrolaNaziv()
    {
        if(!isset($this->smjer->naziv)){
            $this->poruka="Naziv obavezno";
            return false;
        }
        if(strlen(trim($this->smjer->naziv))===0){
            $this->poruka="Naziv obavezno";
            return false;
        }
        if(strlen(trim($this->smjer->naziv))>50){
            $this->poruka="Naziv predugačak";
            return false;
        }
        return true;
    }

    private function kontrolaTrajanje()
    {
        if(!isset($this->smjer->trajanje)){
            $this->poruka="Trajanje obavezno";
            return false;
        }

        if(strlen(trim($this->smjer->trajanje))===0){
            $this->poruka="Trajanje obavezno";
            return false;
        }

        $broj = (int) $this->smjer->trajanje;
        if($broj<=0){
            $this->poruka="Trajanje mora biti pozitivan cijeli broj";
            return false;
        }
        return true;
    }

    private function kontrolaCijena()
    {
        if(!isset($this->smjer->cijena)){
            $this->poruka="Cijena obavezno";
            return false;
        }

        if(strlen(trim($this->smjer->cijena))===0){
            $this->poruka="Cijena obavezno";
            return false;
        }

        $broj = (float) str_replace(array('.', ','), array('', '.'), 
                            $this->smjer->cijena);
        //print_r($broj);
        if($broj<=0){
            $this->poruka="Cijena mora biti pozitivan broj";
            return false;
        }
        return true;
    }

    private function kontrolaCertifikat()
    {
        if(!isset($this->smjer->certifikat)){
            $this->poruka="Indikacija certifikata obavezno";
            $this->smjer->certifikat=null;
            return false;
        }

        return true;
    }

    public function promjena()
    {
        $this->smjer = Smjer::readOne($_GET['sifra']);
        if($this->smjer==null){
            $this->index();
        }else{
            $this->view->render($this->viewDir . 'promjena',[
                'smjer'=>$this->smjer,
                'poruka'=>'Promjenite željene podatke'
            ]);
        }
      
    }

    public function promjeni()
    {
        if(!$_POST){
            $this->index();
            return;
         }
 
         $this->smjer = (object)$_POST;
 
 
         if(
             
             $this->kontrolaNaziv() 
         && $this->kontrolaTrajanje()
         && $this->kontrolaCijena()
         && $this->kontrolaCertifikat()
         
         ){
             //ide spremanje u bazu
             $this->smjer->cijena = str_replace(array('.', ','), array('', '.'), 
             $this->smjer->cijena);
             Smjer::update((array)($this->smjer));
             $this->index();
         }else{
             $this->view->render($this->viewDir . 'promjena',[
                 'smjer'=>$this->smjer,
                 'poruka'=>$this->poruka
             ]); 
         }
    }

    public function brisanje()
    {
       Smjer::delete($_GET['sifra']);
       $this->index();
    }
}