<?php

class GrupaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 
    'grupa' . DIRECTORY_SEPARATOR;
 
    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'grupe'=>Grupa::read()
        ]);
    }

    public function nova()
    {
        //$this->detalji(Grupa::dodajNovu()); - nije dobro
        header('location: ' . App::config('url') . 
        'grupa/detalji/' . Grupa::dodajNovu());
    }

    public function detalji($sifra)
    {

        if($_SERVER['REQUEST_METHOD']==='GET'){
            $this->view->render($this->viewDir . 'detalji',[
                'grupa'=>Grupa::readOne($sifra),
                'poruka'=>'',
                'smjerovi'=>Smjer::read(),
                'predavaci'=>Predavac::read(),
                'dodatniCSS'=>'<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">',
                'dodatniJS'=>'<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
                <script src="' . App::config('url') . 'public/js/grupaautocompletepolaznik.js"></script>'
            ]);
            return;
        }
        if($_SERVER['REQUEST_METHOD']==='POST'){
            Grupa::update($sifra,$_POST);
            $this->index();
        }
        
    }

    public function brisanje()
    {
       Grupa::delete($_GET['sifra']);
       $this->index();
    }

    public function dodajpolaznika()
    {
        Grupa::dodajPolaznika($_POST['polaznik'],$_POST['grupa']);
        echo 'OK';
    }

    public function obrisipolaznika()
    {
        Grupa::obrisiPolaznika($_POST['polaznik'],$_POST['grupa']);
        echo 'OK';
    }

}