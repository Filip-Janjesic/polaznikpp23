<?php

class Grupa
{
    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
                select a.sifra, a.naziv, c.naziv as smjer, 
                concat(e.ime, \' \', e.prezime) as predavac, 
                a.datumpocetka, 
                count(b.polaznik) as clanova 
                from grupa a left join clan b
                on a.sifra = b.grupa 
                inner join smjer c on a.smjer = c.sifra
                left join predavac d on a.predavac = d.sifra
                left join osoba e on d.osoba = e.sifra
                group by a.sifra, a.naziv, a.smjer, 
                a.predavac, a.datumpocetka;
        
        ');

        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function create()
    {
        
    }

    public static function update()
    {
        
    }

    public static function delete()
    {
        
    }

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