<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 05.12.2017
 * Time: 19:38
 */
require_once "../config/config.php";
require_once "../core/autoload.php";
if (isset($_POST['act']) && isset($_POST['id'])){
    if ($_POST['act']=="setBasket"){
        changeOrderStatus($_POST['id']);
        echo Basket::getBasketTable();
    }
}


function changeOrderStatus($id){
    $db=DB::connect();
    $res=$db->query("SELECT order_status FROM `order` where id_order='$id'");
    $res=$res->fetch(PDO::FETCH_NUM);
    $res=$res[0];
    if ($res==0){
        $s=1;
    }
    else{
        $s=0;
    }
    $db->exec("UPDATE `order` SET order_status=$s where id_order=$id");
}