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
    protected $page = 'Index';
    protected $id='';

    function __construct($model,$page='',$id='')
    {
        $this->model=new $model;
        $this->view = new View();
        if ($page!='' || $page!=null){
            $this->page=ucfirst($page);
        }
        if ($id!='' || $id!=null){
            $this->id=$id;
        }
    }
    abstract protected function action_index();
}
