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

    public function smjerovi()
    {

        $smjerovi = Smjer::read();
        foreach($smjerovi as $smjer){
                $smjer->cijena = 
                number_format(
                    $smjer->cijena==null ? 0: $smjer->cijena,
                    2,",",".") . " kn";   
        }

        $this->view->render('smjerovi',[
            'smjerovi'=>$smjerovi
        ]);
    }

    public function unesismjerove()
    {
        for($i=0;$i<100;$i++){
            Smjer::create([
                'naziv'=> 'Moja naziv ' . ($i+1),
                'cijena'=>$i * 10
            ]);
        }
    }
}