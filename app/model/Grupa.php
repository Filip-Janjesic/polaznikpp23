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
                left join smjer c on a.smjer = c.sifra
                left join predavac d on a.predavac = d.sifra
                left join osoba e on d.osoba = e.sifra
                group by a.sifra, a.naziv, a.smjer, 
                a.predavac, a.datumpocetka;
        
        ');

        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function readOne($sifra)
    {
        $veza = DB::getInstanca();
        
        $izraz = $veza->prepare('
        
            select * from grupa where sifra=:sifra
        
        ');

        $izraz->execute(['sifra'=>$sifra]);

        $grupa = $izraz->fetch();

        $izraz = $veza->prepare('
        
                select b.sifra, c.ime, c.prezime
                from
                clan a inner join polaznik b 
                on a.polaznik=b.sifra 
                inner join osoba c
                on b.osoba =c.sifra 
                where a.grupa=:sifra;
        
        ');

        $izraz->execute(['sifra'=>$sifra]);
        $grupa->polaznici = $izraz->fetchAll();
        return $grupa;
    }

    public static function dodajNovu()
    {

        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            insert into grupa(naziv) values (\'\');

        ');
        $izraz->execute();

        return $veza->lastInsertId();
        
    }

    public static function update($sifra,$parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            update grupa set 
                naziv=:naziv,
                smjer=:smjer,
                predavac=:predavac,
                datumpocetka=:datumpocetka
            where sifra=:sifra

        ');

        $izraz->execute([
            'naziv'=>$parametri['naziv'],
            'smjer'=>$parametri['smjer'],
            'predavac'=>$parametri['predavac'],
            'datumpocetka'=>$parametri['datumpocetka'],
            'sifra'=>$sifra,
        ]);
        
    }

    public static function delete($sifra)
    {
        $veza = DB::getInstanca();

        $izraz = $veza->prepare('
        
            delete from grupa where sifra=:sifra

        ');

        $izraz->execute(['sifra'=>$sifra]);
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

    public static function dodajPolaznika($polaznik,$grupa){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            insert into clan(grupa,polaznik) values (:grupa,:polaznik);

        ');
        $izraz->execute(['grupa'=>$grupa, 'polaznik'=>$polaznik]);

    }

    public static function obrisiPolaznika($polaznik,$grupa){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('

            delete from clan where grupa=:grupa and polaznik=:polaznik;

        ');
        $izraz->execute(['grupa'=>$grupa, 'polaznik'=>$polaznik]);

    }

}