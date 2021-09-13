<?php 

class Request
{
    public static function getRuta()
    {
        $ruta = '/';
        if(isset($_SERVER['REDIRECT_PATH_INFO'])){
            $ruta = $_SERVER['REDIRECT_PATH_INFO'];
        }else if (isset($_SERVER['REQUEST_URI'])){
            $ruta = $_SERVER['REQUEST_URI'];
        }
        // dodati bilo što gdje može biti taj podataka
        return $ruta;
    }

    public static function isAutoriziran()
    {
        return isset($_SESSION['autoriziran']);
    }

    public static function user()
    {
        return $_SESSION['autoriziran']->ime . ' ' 
                . $_SESSION['autoriziran']->prezime;
    }

    public static function isAdmin()
    {
        return $_SESSION['autoriziran']->uloga==='admin';
    }
}