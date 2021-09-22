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
}
