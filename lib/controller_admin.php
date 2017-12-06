<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 05.12.2017
 * Time: 20:00
 */

class controller_admin extends Controller
{
    private $login='';
    private $pass='';

    function __construct($model, $page = '', $id = '')
    {
        parent::__construct($model, $page, $id);
        if (isset($_POST['login']) && isset($_POST['password'])){
        $this->login=htmlspecialchars(strip_tags($_POST['login']));
        $this->pass=htmlspecialchars(strip_tags($_POST['password']));
        }
    }

    function action_index()
    {
        if(method_exists($this->model, 'admin')){
            $data=$this->model->admin($this->page,$this->login,$this->pass);
            $this->view->render($data);
        }
        else{
            // здесь также разумнее было бы кинуть исключение
            echo "не нашел страницу логин";
        }
    }

}