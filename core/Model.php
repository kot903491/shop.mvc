<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 0:10
 */

abstract class Model{
    //Базовый класс модели
    protected $data;
    public function __construct(){
        include_once CONFIG_DIR . 'default.php';
        $this->data=$data;
    }
    protected function adminData(){
        include_once CONFIG_DIR . 'admin.php';
        $this->data['basket_view'] = false;
        $this->data['admin']=$admin;
    }
}