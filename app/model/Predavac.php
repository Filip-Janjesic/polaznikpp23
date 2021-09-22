<?php

class Predavac
{

    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select 
            b.ime, b.prezime, b.oib, b.email, a.iban,
            count(c.sifra) as grupa
            from predavac a inner join osoba b
            on a.osoba = b.sifra
            left join grupa c
            on a.sifra =c.predavac 
            group by b.ime, b.prezime, b.oib, b.email, a.iban;
        
        ');

        $izraz->execute();

        return $izraz->fetchAll();
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