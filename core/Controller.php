<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 0:14
 */

abstract class Controller
{
    protected $model;
    protected $view;

    function __construct($model)
    {
        $this->model=new $model;
        $this->view = new View();
    }

    abstract function action_index();

}
