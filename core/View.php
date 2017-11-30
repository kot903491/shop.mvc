<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 0:14
 */

class View
{
    //public $template_view; // здесь можно указать общий вид по умолчанию.
    /*
	$content_file - виды отображающие контент страниц;
	$template_file - общий для всех страниц шаблон;
	$data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
	*/
    function render($data,$tmpl='main.tmpl')
    {
        try{
            $loader = new Twig_Loader_Filesystem(TPL_DIR);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate($tmpl);
            echo $template->render($data);
        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
    }
}