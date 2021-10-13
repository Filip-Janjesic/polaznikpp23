<?php

// https://medium.com/@noufel.gouirhate/create-your-own-mvc-framework-in-php-af7bd1f0ca19
class App
{
    public static function start()
    {
        $ruta = Request::getRuta();
        //echo $ruta . '<br />';
        $djelovi = explode('/',$ruta);
        //echo '<pre>';
        //print_r($djelovi);
        //echo '</pre>';

        $klasa='';
        if(!isset($djelovi[1]) || $djelovi[1]==''){
            $klasa='Index';
        }else{
            $klasa = ucfirst($djelovi[1]);
        }
        $klasa .='Controller';
        //echo $klasa;

        $metoda = ''; // implementacijski je to i dalje funkcion
        if(!isset($djelovi[2]) || $djelovi[2]==''){
            $metoda='index';
        }else{
            $metoda = $djelovi[2];
        }
        $sifra = 0; 
        if(!isset($djelovi[3]) || $djelovi[3]==''){
            $sifra=0;
        }else{
            $sifra = $djelovi[3];
        }
        //echo $klasa . '->' . $metoda . '(' . $sifra . ')';
        if(class_exists($klasa) && method_exists($klasa,$metoda)){
            $instanca = new $klasa();
            if($sifra==0){
                $instanca->$metoda();
            }else{
                $instanca->$metoda($sifra);
            }
            
        }else{
            //error page
            //echo 'Čak niti HGSS ne može naći što tražite ' . 
            //    $klasa . '->' . $metoda;
            $view = new View();
            $view->render('error404',[
                'onoceganema'=>$klasa . '->' . $metoda
            ]);
        }
    }

    public static function config($kljuc)
    {
        $config = include BP_APP . 'konfiguracija.php';
        return $config[$kljuc];
    }

}