<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 1:04
 */

spl_autoload_register(function ($ClassName){

    $class_dir=[CORE_DIR, LIB_DIR, MODEL_DIR, CLASS_DIR];
    $s=false;
    foreach ($class_dir as $value){
        $f=$value.$ClassName.'.php';
        if(file_exists($f)){
            $s=true;
            include_once $f;
        }
    }
    if(!$s){
        echo 'не нашел'.$ClassName;
    }
});
