<?php

class Polaznik
{

    public static function ukupnoPolaznika()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('

                    select count(sifra) from polaznik;

        ');
        $izraz->execute();

        return $izraz->fetchColumn();
    }

    public static function read($stranica)
    {
        $rps = App::config('rezultataPoStranici');
        $od = $stranica * $rps - $rps;

        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select 
            a.sifra, b.ime, b.prezime, b.oib, b.email, a.brojugovora,
            count(c.grupa) as grupa
            from polaznik a inner join osoba b
            on a.osoba = b.sifra
            left join clan c
            on a.sifra =c.polaznik 
            group by a.sifra, b.ime, b.prezime, b.oib, 
            b.email, a.brojugovora
            limit :od,:rps;
        
        
        ');

        $izraz->bindValue('od', $od, PDO::PARAM_INT);
        $izraz->bindValue('rps', $rps, PDO::PARAM_INT);

        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function readOne($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select 
            a.sifra, b.ime, b.prezime, b.oib, b.email, a.brojugovora
            from polaznik a inner join osoba b
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

        insert into polaznik(osoba,brojugovora) values
        (:osoba,:brojugovora);

        ');
        $izraz->execute([
            'osoba'=>$zadnjaSifra,
            'brojugovora'=>$parametri['brojugovora']
        ]);


        $veza->commit();


    }

    public static function update($sifra,$parametri)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();

        $izraz=$veza->prepare('

        select osoba from polaznik where sifra=:sifra

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

        update predavac set brojugovora=:brojugovora where sifra=:sifra

        ');
        $izraz->execute([
            'brojugovora'=>$parametri['brojugovora'],
            'sifra'=>$sifra
        ]);


        $veza->commit();
    }

    public static function delete($sifra)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();

        $izraz=$veza->prepare('

        select osoba from polaznik where sifra=:sifra

        ');
        $izraz->bindParam('sifra',$sifra);
        $izraz->execute();
        $sifraOsoba = $izraz->fetchColumn();


        $izraz=$veza->prepare('

           delete from polaznik 
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