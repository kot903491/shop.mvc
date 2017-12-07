<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 05.12.2017
 * Time: 20:09
 */

class model_admin extends Model
{
    public function __construct()
    {
        parent::__construct();
        include_once CONFIG_DIR . 'admin.php';
        $this->data['basket_view'] = false;
        $this->data['admin']=$admin;
    }

    function admin($page,$login='',$pass=''){
        if (Admin::checkAdmin() || $page=='Login'){
            $page='admin'.$page;
            $result=$this->$page($login,$pass);
            setcookie('hash',sult_cookie,(time()+600),'/');
        }
        else{
            $result=$this->adminLoginPage();
        }
        return $result;
    }

    private function adminIndex(){
        try {
            $loader = new Twig_Loader_Filesystem(ADMIN_TPL);
            $twig = new Twig_Environment($loader);
            $template = $twig->loadTemplate('admin_menu.tmpl');
            $this->data['content'] = $template->render(['admin' => $this->data['admin']]);
            $this->data['header'] = 'admin_header.tmpl';
            $this->data['path'] = ADMIN_TPL;
            $this->data['tmpl'] = 'admin_main.tmpl';
            $this->data['title'] = "Админка";
            return $this->data;
        } catch (Exception $e) {
            die('ERROR: ' . $e->getMessage());

        }
    }

    private function adminLoginPage(){
        Admin::unsetAdmin();
        try{
            $loader = new Twig_Loader_Filesystem(ADMIN_TPL);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate('admin_auth.tmpl');
            $this->data['content']=$template->render(['admin'=>$this->data['admin']]);
            $this->data['title']='Авторизация';
        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
        return $this->data;
    }

    private function adminLogin($login,$pass){
        Admin::checkCredital($login,$pass);
    }

    private function adminLogout(){
        Admin::unsetAdmin();
        header("Refresh: 5; /");
        echo 'Вы вышли. Через пять секунд вы будете перемещены на главную страницу';
        die();
    }
	
	private function adminBasket(){
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
}