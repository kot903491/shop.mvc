<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 1:04
 */

spl_autoload_register(function ($ClassName){
    $class_base=CORE_DIR.$ClassName.'.php';
    $class_child=LIB_DIR.$ClassName.'.php';
    $class_model=MODEL_DIR.$ClassName.'.php';
    if (file_exists($class_base)){
    include_once $class_base;
    }
    elseif(file_exists($class_child)){
    include_once $class_child;
    }
    elseif(file_exists($class_model)){
        include_once $class_model;
    }
    else{
        echo 'не нашел'.$ClassName;
    }
});
