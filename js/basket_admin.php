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
        echo getBasketTable();
    }
}

function getBasketTable(){
    $db=DB::connect();
    $res=$db->query("SELECT order_product.id_order,sum(order_product.count) as allcount, sum(order_product.count*product.price) as summ, `order`.order_status as status FROM order_product 
inner join product on order_product.id_product=product.id
inner join `order` on order_product.id_order=`order`.id_order
group by id_order;");
    $table="<table><tr><td>№ заказа</td><td>Всего товаров</td><td>Сумма заказа</td><td>Статус</td></tr>";
    while($row=$res->fetch()) {
        switch ($row['status']) {
            case 0:
                $status = "Выполняется";
                break;
            case 1:
                $status = "Завершен";
                break;
        }
        $table .= "<tr><td>" . $row['id_order'] . "</td><td>" . $row['allcount'] . "</td><td>" . $row['summ'] . "</td><td>$status</td>
<td><button id='button' onclick='changeOrderStatus(" . $row['id_order'] . ")'>Изменить</button></td></tr>";
    }
    $table.="</table>";
    return $table;
}

function changeOrderStatus($id){
    $db=DB::connect();
    $res=$db->query("SELECT order_status FROM `order` where id_order='$id';");
    $res=$res->fetch();
    $res=$res[0];
    if ($res==0){
        $s=1;
    }
    else{
        $s=0;
    }
    $db->exec("UPDATE `order` SET order_status=$s where id_order=$id");
}