<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 08.12.2017
 * Time: 0:03
 */

class model_apage extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->adminData();
    }

    public function Login(){
        $data=model_admin::adminLoginPage();
        $this->data['content']=$data['content'];
        $this->data['title']=$data['title'];
        return $this->data;
    }

    public function getBasket(){
        try {
            $loader = new Twig_Loader_Filesystem(ADMIN_TPL);
            $twig = new Twig_Environment($loader);
            $template = $twig->loadTemplate('admin_basket.tmpl');
            $this->data['content'] = $template->render(['getBasketTable'=>Basket::getBasketTable()]);
            $this->data['header'] = 'admin_header.tmpl';
            $this->data['path'] = ADMIN_TPL;
            $this->data['tmpl'] = 'admin_main.tmpl';
            $this->data['title'] = "Админка-корзина";
            return $this->data;
        } catch (Exception $e) {
            die('ERROR: ' . $e->getMessage());

        }
    }

    public function getAdd()
    {
        if (isset($_POST['submit'])) {
            ActionGood::addNew($_POST);
        }
        try {
            $loader = new Twig_Loader_Filesystem(ADMIN_TPL);
            $twig = new Twig_Environment($loader);
            $template = $twig->loadTemplate('admin_goods.tmpl');
            $this->data['content'] = $template->render(['check' => ActionGood::getNew()]);
            $this->data['header'] = 'admin_header.tmpl';
            $this->data['path'] = ADMIN_TPL;
            $this->data['tmpl'] = 'admin_main.tmpl';
            $this->data['title'] = "Админка-добавление";
            return $this->data;
        } catch (Exception $e) {
            die('ERROR: ' . $e->getMessage());
        }

    }
}