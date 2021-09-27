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
        $veza = DB::getInstanca();
        $veza->beginTransaction();


        $izraz=$veza->prepare('

            insert into osoba(ime,prezime,email,oib) values
            (:ime,:prezime,:email,:oib);

        ');
        $izraz->execute([
            'ime'=>$parametri['ime'],
            'prezime'=>$parametri['prezime'],
            'email'=>$parametri['email'],
            'oib'=>$parametri['oib']
        ]);

        $zadnjaSifra = $veza->lastInsertId();

        $izraz=$veza->prepare('

        insert into predavac(osoba,iban) values
        (:osoba,:iban);

        ');
        $izraz->execute([
            'osoba'=>$zadnjaSifra,
            'iban'=>$parametri['iban']
        ]);


        $veza->commit();


    }

    public static function update($sifra,$parametri)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();

        $izraz=$veza->prepare('

        select osoba from predavac where sifra=:sifra

        ');
        $izraz->bindParam('sifra',$sifra);
        $izraz->execute();
        $sifraOsoba = $izraz->fetchColumn();


        $izraz=$veza->prepare('

            update osoba set
            ime=:ime,
            prezime=:prezime,
            email=:email,
            oib=:oib
            where sifra=:sifra

        ');
        $izraz->execute([
            'ime'=>$parametri['ime'],
            'prezime'=>$parametri['prezime'],
            'email'=>$parametri['email'],
            'oib'=>$parametri['oib'],
            'sifra'=>$sifraOsoba
        ]);

       

        $izraz=$veza->prepare('

        update predavac set iban=:iban where sifra=:sifra

        ');
        $izraz->execute([
            'iban'=>$parametri['iban'],
            'sifra'=>$sifra
        ]);


        $veza->commit();
    }

    public static function delete($sifra)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();

        $izraz=$veza->prepare('

        select osoba from predavac where sifra=:sifra

        ');
        $izraz->bindParam('sifra',$sifra);
        $izraz->execute();
        $sifraOsoba = $izraz->fetchColumn();


        $izraz=$veza->prepare('

           delete from predavac 
            where sifra=:sifra

        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);

       

        $izraz=$veza->prepare('

        delete from osoba where sifra=:sifra

        ');
        $izraz->execute([
            'sifra'=>$sifraOsoba
        ]);


        $veza->commit();
    }

}