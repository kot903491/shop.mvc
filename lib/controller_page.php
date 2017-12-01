<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 01.12.2017
 * Time: 1:00
 */

class controller_page extends Controller
{
    function action_index()
    {
        $page='get'.$this->page;
        if(method_exists($this->model, $page)){
            $data=$this->model->$page($this->id);
            $this->view->render($data);
        }
        else{
            // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
        }
    }
    /*function action_good($id)
    {
        $data=$this->model->getPage($id);
        $this->view->render($data);
    }*/
}