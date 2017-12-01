<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 28.11.2017
 * Time: 13:38
 */
require_once "../config/config.php";
require_once "../core/autoload.php";

echo getCatalog($_POST['amt']);
function getCatalog($pages){
    $str='';
    $db=db::connect();
    $res = $db->query('SELECT count(id) from product');
    $res=$res->fetch(PDO::FETCH_NUM);
    $res=$res[0];
    if($pages>$res){
        $pages=$res;
        $amtbut='';
    }
    else{
        $amt=$pages+4;
        $amtbut='<button onclick="getCatalog('.$amt.')">Показать еще 4 комикса</button>';
    }
    $res = $db->query("select product.id,product.name, desk.s_desk, gallery.s_img FROM product inner join desk on desk.id=product.id inner join gallery on gallery.id=product.id LIMIT $pages");
    while ($res_all = $res->fetch()) {
        $res_all['s_img']=GALLERY_DIR.$res_all['s_img'];
        $result[] = $res_all;
    }
    foreach ($result as $value){
    $str.='<div class="desc">';
    $str.='<h3>'.$value['name'].'</h3>';
    $str.='<div class="cat_img"><img src="'.$value['s_img'].'"></div>';
    $str.='<p>'.$value['s_desk'].'</p>';
    $str.='<div class="link"><a href="/page/good/'.$value['id'].'">Подробнее...</a></div></div>';
    }
    $str.=$amtbut;
    return $str;
}