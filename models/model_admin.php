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
        if ($this->checkAdmin() || $page=='Login'){
            $page=admin.$page;
            $result=$this->$page($login,$pass);
        }
        else{
            $result=$this->adminLoginPage();
        }
        return $result;
    }

    private function adminIndex()
    {
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
        $this->unsetAdmin();
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
        $this->checkCredital($login,$pass);
    }

    private function adminLogout(){
        $this->unsetAdmin();
        header("Refresh: 5; /");
        echo 'Вы вышли. Через пять секунд вы будете перемещены на главную страницу';
        die();
    }

    private function checkAdmin()
    {
        $check = false;
        if (isset($_COOKIE['hash']) && $_COOKIE['hash'] === sult_cookie) {
            if (isset($_SESSION['name']) && isset($_SESSION['rand'])) {
                $db = DB::connect();
                $hash = $db->query('SELECT hash FROM users WHERE login="' . $_SESSION['name'].'"');
                $hash = $hash->fetch(PDO::FETCH_NUM);
                if (md5(md5($_SESSION['rand']) . md5(sult_cookie)) === $hash[0]) {
                    $check = true;
                }
            }
        }
        return $check;
    }

    private function checkCredital($login,$pass){
        if ($login!='' && $pass!=''){
            $sult='12hdfgrtr23123er565hghjmvcdkdjkytrh';
            $db=DB::connect();
            $res=$db->query('SELECT password FROM users WHERE login="'.$login.'"');
            $res=$res->fetch();
            if ($res['password']==md5($pass).$sult){
                $this->setAdmin($login,rand(0,500));
                $str="Авторизация успешна. Вы будете перенаправлены через 5 секунд";
            }
            else{
                $str="Неверный логин или пароль. Попробуйте еще раз через 5 секунд";
            }
        }
        header("Refresh: 5; /admin/");
        echo $str;
        die();
    }

    private function setAdmin($login,$rand){
        $db=DB::connect();
        $hash=md5(md5($rand) . md5(sult_cookie));
        $db->exec('UPDATE users SET hash="'.$hash.'" WHERE login="'.$login.'"');
        setcookie('hash',sult_cookie,(time()+3600),'/');
        $_SESSION['name']=$login;
        $_SESSION['rand']=$rand;
    }

    private function unsetAdmin(){
            if (isset($_SESSION['name'])){
                unset($_SESSION['name']);
            }
            if (isset($_SESSION['rand'])){
                unset($_SESSION['rand']);
            }
            if(isset($_COOKIE['hash'])){
                setcookie('hash','',time()-1,'/');
            }
        session_destroy();
    }
}