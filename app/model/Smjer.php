<?php

class Smjer
{
    //CRUD - R
    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select * from smjer
        
        ');

        $izraz->execute();

        return $izraz->fetchAll();
    }

    //CRUD - C
    public static function create($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            insert into smjer(naziv,cijena) values (:naziv,:cijena)
        
        ');

        $izraz->execute($parametri);
    }
}