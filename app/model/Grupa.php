<?php

class Grupa
{

    public static function brojClanovaPoGrupi()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select a.naziv, count(b.polaznik) as ukupno
            from grupa a
            left join clan b on a.sifra =b.grupa 
            group by a.naziv;
            
        ');

        $izraz->execute();

        return $izraz->fetchAll();
    }

}