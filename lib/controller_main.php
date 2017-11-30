<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 12:59
 */

class controller_main extends Controller
{
    function action_index()
    {
        // TODO: Implement action_index() method.
        $data=$this->model->getIndex();
        $this->view->render($data);
    }
    function action_good($id)
    {
        $data=$this->model->getPage($id);
        $this->view->render($data);
    }
}