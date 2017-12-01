<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 12:43
 */

class Route
{
    static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'Main';
        $action_name = 'index';
        $id='';
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        // получаем имя контроллера
        if ( !empty($routes[1]) )
        {
            $controller_name = $routes[1];
        }
        // получаем имя экшена
        if ( !empty($routes[2]) )
        {
            $page_name = $routes[2];
        }
        if(!empty($routes[3])){
            $id=(int)$routes[3];
        }
        // добавляем префиксы
        $model_name = strtolower('Model_'.$controller_name);
        $controller_name = strtolower('Controller_'.$controller_name);
        //$action_name = 'action_'.$action_name;

        // создаем контроллер
        $controller = new $controller_name($model_name,$page_name,$id);
        $action = 'action_index';

        if(method_exists($controller, $action))
        {
            // вызываем действие контроллера
            $controller->$action();
        }
        else
        {
            // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
        }

    }

    function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }

}