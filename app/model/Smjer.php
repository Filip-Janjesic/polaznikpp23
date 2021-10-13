<?php

class Smjer
{
    //CRUD - R
    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
                select 
                a.sifra,a.naziv,a.cijena,a.trajanje,
                a.certifikat,
                count(b.sifra) as grupa
                from smjer a left join grupa b 
                on a.sifra=b.smjer
                group by a.sifra,a.naziv,a.cijena,a.trajanje,
                a.certifikat;
        
        ');

        $izraz->execute();

        return $izraz->fetchAll();
    }

    public static function readOne($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select * from smjer where sifra=:sifra
        
        ');

        $izraz->execute(['sifra'=>$sifra]);

        return $izraz->fetch();
    }

    //CRUD - C
    public static function create($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            insert into smjer(naziv,trajanje,cijena,certifikat) 
            values (:naziv,:trajanje,:cijena,:certifikat)
        
        ');

        $izraz->execute($parametri);
    }

    //CRUD - U
    public static function update($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            update smjer set 
                naziv=:naziv,
                trajanje=:trajanje,
                cijena=:cijena,
                certifikat=:certifikat
            where sifra=:sifra

        ');

        $izraz->execute($parametri);
    }

     //CRUD - D
     public static function delete($sifra)
     {
         $veza = DB::getInstanca();
         $izraz = $veza->prepare('
         
             delete from smjer where sifra=:sifra

         ');
 
         $izraz->execute(['sifra'=>$sifra]);
     }

     public static function grupe($sifra)
     {
         $veza = DB::getInstanca();
         $izraz = $veza->prepare('
         
             select naziv from grupa where smjer=:sifra
         
         ');
 
         $izraz->execute(['sifra'=>$sifra]);
 
         return $izraz->fetchAll();
     }
}