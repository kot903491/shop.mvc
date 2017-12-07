<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 07.12.2017
 * Time: 23:48
 */

class controller_apage extends Controller
{
    function action_index()
    {
        if(Admin::checkAdmin()) {
            $page='get'.$this->page;
            if (method_exists($this->model, $page)) {
                $data = $this->model->$page();
                $this->view->render($data);
            } else {
                // здесь также разумнее было бы кинуть исключение
                echo "не нашел страницу $page";
            }
        }
        else{
            header("Refresh: 0; /admin/");
        }
    }
}