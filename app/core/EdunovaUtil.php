<?php

class EdunovaUtil
{
    public static function inputText($name, $value)
    {
        ?>
        <label><?=$name?>
            <input type="text" name="<?=$name?>"
            value="<?=$value?>">
        </label>
        <?php
        
    }


    public static function inputTextArray($o)
    {
       foreach($o as $key=>$value){
           if($key==='sifra'){
               continue;
           }
           echo '<label>'. ucfirst($key) . '
           <input type="text" name="'. $key . '"
           value="'. $value . '">
       </label>';
       }
    }


    public static function verzija() {
        exec('git describe --always',$version_mini_hash);
        exec('git rev-list HEAD | wc -l',$version_number);
        exec('git log -1',$line);
        return $version_mini_hash[0];
      }
}
