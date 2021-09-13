<?php

$dev = $_SERVER['REMOTE_ADDR']==='127.0.0.1' ? true : false;

if($dev)
{
    $baza = [
        'server'=>'localhost',
        'baza'=>'edunovapp23',
        'korisnik'=>'edunova',
        'lozinka'=>'edunova'
    ];
    $url = 'http://polaznikpp23.xyz/';
}
else
{
    $baza = [
        'server'=>'localhost',
        'baza'=>'afrodita_pp23',
        'korisnik'=>'afrodita_pp23',
        'lozinka'=>'t84durft1994@'
    ];
    $url = 'https://polaznik12.edunova.hr/';
}

return [
    'dev' => $dev,
    'nazivApp'=>'Edunova APP',
    'url'=> $url,

    'baza'=> $baza
];