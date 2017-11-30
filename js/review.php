<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 05.11.2017
 * Time: 15:25
 */
require_once "../config/config.php";
if (isset($_POST['id'])&&isset($_POST['name'])&&isset($_POST['review'])) {
    $id = (int)$_POST['id'];
    $dat = date("y.m.d H:m:s");
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $em = htmlspecialchars(strip_tags($_POST['email']));
    $review = htmlspecialchars(strip_tags($_POST['review']));
    if($name!="" && $em!="" && $review!="") {
        $mysqli = new mysqli(SQL_SERVER, SQL_USER, SQL_PASS, dbname, SQL_PORT);
        $mysqli->query("INSERT INTO review(id,name,email,datetime,review) VALUES($id,'$name','$em','$dat','$review')");
        unset($_POST);
        $mysqli->close();
        echo "Данные внесены";
    }else{
        echo "Заполнены не все поля.";
    }
}
else{
    $id = (int)$_POST['id'];
    $mysqli = new mysqli(SQL_SERVER, SQL_USER, SQL_PASS, dbname, SQL_PORT);
    $res=$mysqli->query("SELECT name,datetime,review from review where id=$id ORDER BY datetime");
    $str="";
    while ($result=$res->fetch_assoc()){
        $name=$result['name'];
        $dat=date("d.m.y H:m",strtotime($result['datetime']));
        $rew=$result['review'];
        $str.="<p>$rew</p><span>$name $dat</span><hr>";
    }
    echo $str;
}