
// daljenje čitanje
//https://www.ecma-international.org/publications-and-standards/standards/ecma-262/
//https://scotch.io/tutorials/javascript-transpilers-what-they-are-why-we-need-them
// https://obfuscator.io/


//https://github.com/tjakopec/CistiJS
//https://github.com/tjakopec/OSC3JS
//https://github.com/tjakopec/AngularJS-PHP-PDO-CRUD
//https://github.com/tjakopec/ZSI2016
//https://github.com/tjakopec/OSC3JST

document.write('Hello world');

console.log('Hello World');

let ime = 'Edunova';
console.log(typeof ime);


let brojd = 2.1;
console.log(typeof brojd);

let niz = []; // Array();
console.log(typeof niz);

let aniz = [];
aniz['kljuc']='vrijednost';
console.log(aniz);

let iniz = [1,'',true,3.6];
console.log(iniz);

let s = true;
console.log(typeof s);

let jsonObjekt = {ime: 'Pero', godine: 22};
console.log(jsonObjekt);

// https://www.json.org/json-en.html

let grupe = [
    {
        sifra: 1,
        naziv: 'PP23',
        smjer: {
            sifra: 1,
            naziv: 'PHP programiranje'
        }
    },
    {
        sifra: 2,
        naziv: 'JP24',
        smjer: {
            sifra: 2,
            naziv: 'Java programiranje'
        }
    }

];

console.log(grupe);


let broj = 2;
console.log(typeof broj);

if(broj==='2'){
    console.log('Osijek');
}


for(let i=0;i<10;i++){
    console.log(i);
}


while(true){
    break;
}

function zbroji(p,d){
    return p+d;
}

console.log(zbroji(4,1));
/*
function promjeniIme(){
    document.getElementById('naslov').innerHTML='Promjenjeno';
}

document.getElementById('gumb').addEventListener('click',function(){
    document.getElementById('naslov').innerHTML='Promjenjeno';
});

document.getElementById('gumb2').addEventListener('click',function(){
    document.getElementById('naslov').innerHTML='Osijek';
});

*/

$('#gumb').click(function(){
    $('#naslov').html('Promjenjeno');
});

$('#gumb2').click(function(){
    
    $.ajax({
        url: '/public/js/datoteka.txt',
        cache: false,
        success: function(odgovor){
            $('#naslov').html(odgovor);
        }
    });

});


$('#gumb3').click(function(){
    
    $.ajax({
        url: '/index/ajax',
        cache: false,
        success: function(odgovor){
            let o = JSON.parse(odgovor);
            $('#naslov').html('<a href="">' + o[0].naziv + '</a>');
        }
    });

});
