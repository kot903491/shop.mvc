<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 0:10
 */

abstract class Model{
    //Базовый класс модели
    protected function getDefault(){
        include_once CORE_DIR.'default.php';
        return $data;
    }
    abstract public function getIndex();
    abstract protected function getPage($id);
}