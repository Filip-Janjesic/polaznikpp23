<?php

class NadzornaplocaController extends AutorizacijaController
{
    public function index()
    {
        $this->view->render('privatno' . 
        DIRECTORY_SEPARATOR . 'nadzornaploca',[
            'podaci' => $this->brojClanovaPoGrupiJSON(),
            'dodatniCSS'=>'<link rel="stylesheet" href="' . App::config('url') . 'public/css/hightcharts.css">',
            'dodatniJS'=>'<script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/export-data.js"></script>
            <script src="https://code.highcharts.com/modules/accessibility.js"></script>
            <script src="' . App::config('url') . 'public/js/hightchartsnadzorna.js"></script>'
           ]);
    }

    private function brojClanovaPoGrupiJSON(){
        $podaci = Grupa::brojClanovaPoGrupi();
        $s = '<script>let podaci=[';
        foreach($podaci as $p){
            $s.="{name: '" . $p->naziv . "',y: " . $p->ukupno . "},";
        }
        $s.=']</script>';
        return $s;
    }
}