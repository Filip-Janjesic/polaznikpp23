<?php

$dev = $_SERVER['REMOTE_ADDR']==='127.0.0.1' ? true : false;

if($dev){
    $baza = [
        'server'=>'localhost',
        'baza'=>'edunovapp23',
        'korisnik'=>'edunova',
        'lozinka'=>'edunova'
    ];
    $url = 'http://edunovapp23.xyz/';
}else{
    $baza=[
        'server'=>'localhost',
        'baza'=>'cesar_pp23',
        'korisnik'=>'cesar_pp23',
        'lozinka'=>'Edunova1.'
    ];
    $url = 'https://polaznikpp23.edunova.hr/';
}

return [
    'dev' => $dev,
    'nazivApp'=>'Edunova APP',
    'url'=>$url,
    'baza'=> $baza,
    'rezultataPoStranici'=>12
];