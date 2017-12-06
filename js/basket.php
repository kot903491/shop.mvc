<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 07.11.2017
 * Time: 13:38
 */
require_once "../config/config.php";
require_once "../core/autoload.php";

require_once "../config/config.php";
if (isset($_POST['basket'])=='getBasketTable'){
    switch ($_POST['basket']) {
        case 'getBasketTable':
            if (isset($_COOKIE['basket_product'])){
            echo basketTable();}
            break;
        case "deleteBasket":
            if (isset($_POST['key'])){
                echo deleteBasketId($_POST['key']);
            }
            break;
    }
}
elseif (isset($_POST['id'])){
    echo setBasket((int)$_POST['id']);
}
else{
    echo getBasket();
}

function getBasket(){
    if (!isset($_COOKIE['basket_product'])){
        $str="<a href='/page/basket/'>В корзине пусто</a>";
        return $str;
    }
    else{
        $basket=unserialize($_COOKIE['basket_product']);
        $count=count($basket);
        switch ($count){
            case 1:
                $t="товар";
                break;
            case 2:
            case 3:
            case 4:
                $t="товара";
                break;
            default:
                $t="товаров";
        }
        $price=0;
        foreach ($basket as $value){
            $price +=$value['price'];
        }
        $str="<a href='/page/basket/'>В корзине $count $t на сумму $price тг</a>";
        return $str;
    }
}

function setBasket($id){
    $db = DB::connect();
    if (!isset($_COOKIE['basket_product'])){
        $res=$db->query('SELECT price FROM product WHERE id='.$id);
        $res=$res->fetch();
        $price=$res['price'];
        $basket[]=['id'=>$id, 'price'=>$price];
        setcookie('basket_product',serialize($basket),time()+1500,"/");
        return "<a href='/page/basket/'>В корзине 1 товар на сумму $price тг</a>";
    }
    else{
        $basket=unserialize($_COOKIE['basket_product']);
        setcookie('basket_product',"",time()-1,"/");
        $res=$db->query('SELECT price FROM product WHERE id='.$id);
        $res=$res->fetch();
        $price=$res['price'];
        $basket[]=['id'=>$id,'price'=>$price];
        setcookie('basket_product',serialize($basket),time()+3600,"/");
        $count=count($basket);
        switch ($count){
            case 1:
                $t="товар";
                break;
            case 2:
            case 3:
            case 4:
                $t="товара";
                break;
            default:
                $t="товаров";
        }
        $price=0;
        foreach ($basket as $value){
            $price +=$value['price'];
        }
        $str="<a href='/page/basket/'>В корзине $count $t на сумму $price тг</a>";
        return $str;
        }
}
function basketTable(){
    if (isset($_COOKIE['basket_product'])) {
        $basket = unserialize($_COOKIE['basket_product']);
        $db=DB::connect();
        foreach ($basket as $key => $value) {
            $res = $db->query("SELECT name FROM product WHERE id=" . $value['id']);
            $res = $res->fetch();
            $basket[$key]['name'] = $res['name'];
        }
        $str = "<table><tr><td>Название</td><td>Цена</td></tr>";
        $price = 0;
        foreach ($basket as $key => $value) {
            $price += $value['price'];
            $str .= "<tr><td>" . $value['name'] . "</td><td>" . $value['price'] . "</td><td>
        <button id='key' onclick='deleteBasketId($key)'>Удалить</button></td></tr>";
        }
        $str .= "<tr><td>ИТОГО</td><td>$price</td></tr></table>";
        return $str;
    }
}

function deleteBasketId($key){
    $basket=unserialize($_COOKIE['basket_product']);
    setcookie('basket_product',"",time()-1,"/");
    unset($basket[$key]);
    if(count($basket)>0) {
        foreach ($basket as $value) {
            $basket_new[] = $value;
        }
        unset ($basket);
        setcookie('basket_product', serialize($basket_new), time() + 3600, "/");
        $db = DB::connect();
        $price = 0;
        $str = "<table><tr><td>Название</td><td>Цена</td></tr>";
        foreach ($basket_new as $key => $value) {
            $res = $db->query("SELECT name FROM product WHERE id=" . $value['id']);
            $res = $res->fetch();
            $price += $value['price'];
            $str .= "<tr><td>" . $res['name'] . "</td><td>" . $value['price'] . "</td><td>
        <button id='key' onclick='deleteBasketId($key)'>Удалить</button></td></tr>";
        }
        $str .= "<tr><td>ИТОГО</td><td>$price</td></tr></table>";
        return $str;
    }
}