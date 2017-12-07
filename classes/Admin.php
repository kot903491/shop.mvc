<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 07.12.2017
 * Time: 23:26
 */

class Admin
{
    function checkAdmin(){
        $check = false;
        if (isset($_COOKIE['hash']) && $_COOKIE['hash'] === sult_cookie) {
            if (isset($_SESSION['name']) && isset($_SESSION['rand'])) {
                $db = DB::connect();
                $hash = $db->query('SELECT hash FROM users WHERE login="' . $_SESSION['name'].'"');
                $hash = $hash->fetch(PDO::FETCH_NUM);
                if (md5(md5($_SESSION['rand']) . md5(sult_cookie)) === $hash[0]) {
                    $check = true;
                    setcookie('hash',sult_cookie,(time()-1),'/');
                    setcookie('hash',sult_cookie,(time()+600),'/');
                }
            }
        }
        return $check;
    }

    function checkCredital($login,$pass){
        if ($login!='' && $pass!=''){
            $sult='12hdfgrtr23123er565hghjmvcdkdjkytrh';
            $db=DB::connect();
            $res=$db->query('SELECT password FROM users WHERE login="'.$login.'"');
            $res=$res->fetch();
            if ($res['password']==md5($pass).$sult){
                self::setAdmin($login,rand(0,500));
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
        setcookie('hash',sult_cookie,(time()-1),'/');
        setcookie('hash',sult_cookie,(time()+600),'/');
        $_SESSION['name']=$login;
        $_SESSION['rand']=$rand;
    }

    function unsetAdmin(){
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