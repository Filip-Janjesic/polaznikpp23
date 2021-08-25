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
        if(!isset($djelovi[1]) || $djelovi[1]=''){
            $klasa='Index';
        }
    }
}