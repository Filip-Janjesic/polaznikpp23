<?php

class Predavac
{

    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select 
            a.sifra, b.ime, b.prezime, b.oib, b.email, a.iban,
            count(c.sifra) as grupa
            from predavac a inner join osoba b
            on a.osoba = b.sifra
            left join grupa c
            on a.sifra =c.predavac 
            group by a.sifra, b.ime, b.prezime, b.oib, b.email, a.iban;
        
        ');

        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function readOne($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select 
            a.sifra, b.ime, b.prezime, b.oib, b.email, a.iban
            from predavac a inner join osoba b
            on a.osoba = b.sifra
            where a.sifra=:sifra
        
        ');

        $izraz->execute(['sifra'=>$sifra]);

        return $izraz->fetch();
    }

    public static function create($parametri)
    {

    }

    public static function update($parametri)
    {

    }

    public static function delete($parametri)
    {

    }

}