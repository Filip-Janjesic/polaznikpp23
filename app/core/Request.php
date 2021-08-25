<?php 

class Request
{
    public static function getRuta()
    {
        $ruta = '/';
        if(isset($_SERVER['REDIRECTION_PATH_INFO'])){
            $ruta = $_SERVER['REDIRECTION_PATH_INFO'];
        }else if (isset($_SERVER['REQUEST_URI'])){
            $ruta = $_SERVER['REQUEST_URI'];
        }
        // dodati bilo što gdje može biti taj podataka
        return $ruta;
    }
}