<?php

class SmjerController extends AutorizacijaController
{

    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 
                        'smjer' . DIRECTORY_SEPARATOR;
    private $slikaDir = BP . DIRECTORY_SEPARATOR . 
    'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR .
    'smjer' . DIRECTORY_SEPARATOR;
    private $smjer;
    private $poruka;
    private $nf;

    public function __construct()
    {
        parent::__construct();
        $this->smjer = new stdClass();
        $this->smjer->naziv='';
        $this->smjer->cijena='0,00';
        $this->smjer->trajanje='100';
        $this->smjer->certifikat=true;
        $this->nf = new \NumberFormatter("hr-HR", \NumberFormatter::DECIMAL);
        $this->nf->setPattern("#,##0.00");
    }

    public function index()
    {

        // Apstrakna klasa je ona klasa koja ne može imati instancu
        // Kreira se s cilje da ju druge klase nasljede a ona da ima
        // neka zajednička svojstva svim podklasama
        //$c = new Controller();


        $smjerovi = Smjer::read();
        
        foreach($smjerovi as $smjer){
            $smjer->cijena = $this->nf->format($smjer->cijena);

            if(file_exists($this->slikaDir . $smjer->sifra . '.jpg')){
                    $smjer->slika = '<img src="' . App::config('url') . 'public/img/smjer/' . $smjer->sifra . '.jpg" alt="' . $smjer->naziv . '" />';
                }else{
                    $smjer->slika='';
                }
        }
       
        $this->view->render($this->viewDir . 'index',[
            'smjerovi'=>$smjerovi,
            'dodatniJS'=>'<script src="' . App::config('url') . 'public/js/smjerDetaljiGrupe.js"></script>'
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
            $this->smjer->cijena = $this->nf->format($this->smjer->cijena);
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
             if(isset($_FILES['slika'])){
                move_uploaded_file($_FILES['slika']['tmp_name'],
                $this->slikaDir . $this->smjer->sifra . '.jpg');
             }
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
       if(file_exists($this->slikaDir .$_GET['sifra'] . '.jpg')){
          unlink($this->slikaDir .$_GET['sifra'] . '.jpg');
       }
       $this->index();
    }

    public function grupe()
    {
    $grupe = [];
       foreach(Smjer::grupe($_POST['smjer']) as $g){
           $grupe[]=$g->naziv;
       }
       echo join(', ', $grupe);
    }
}