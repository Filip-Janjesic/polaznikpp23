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
                'predavaci'=>Predavac::read()
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


}