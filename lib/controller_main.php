<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 12:59
 */

class controller_main extends Controller
{
    public function action_index()
    {
        // TODO: Implement action_index() method.
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
}