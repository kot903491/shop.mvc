<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 02.12.2017
 * Time: 0:00
 */

class Basket
{
    public function setOrder($klient){
        $name = htmlspecialchars(strip_tags($klient['name']));
        $tel = htmlspecialchars(strip_tags($klient['tel']));
        $address = htmlspecialchars(strip_tags($klient['address']));
        $email = htmlspecialchars(strip_tags($klient['email']));
        $date = date("Y-m-d H:m:s");
        $basket = unserialize($_COOKIE['basket_product']);
        $i = 0;
        while (!empty($basket)) {
            $basket_order[$i] = ['id' => $basket[0]['id'], 'count' => 1];
            unset ($basket[0]);
            foreach ($basket as $key => $value) {
                if ($value['id'] == $basket_order[$i]['id']) {
                    $basket_order[$i]['count'] += 1;
                    unset ($basket[$key]);
                } else {
                    $basket_new[] = $value;
                }
            }
            $basket = $basket_new;
            unset($basket_new);
            $i++;
        }
        $db=DB::connect();
        $db->exec("INSERT INTO `order`(order_date,order_name,order_tel,opder_email,order_address,order_status) VALUES('$date','$name','$tel','$email','$address',0)");
        $i = $db->lastInsertId();
        foreach ($basket_order as $value) {
            $prod_id = $value['id'];
            $prod_count = $value['count'];
            $db->exec("INSERT INTO order_product(id_order,id_product,`count`) VALUES($i,$prod_id,$prod_count)");
        }
        setcookie('basket_product', "", time() - 1, "/");
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
	
	public function getBasketTable(){
    $db=DB::connect();
    $res=$db->query("SELECT order_product.id_order,`order`.order_date as date, sum(order_product.count) as allcount, sum(order_product.count*product.price) as summ, `order`.order_status as status 
	FROM order_product 
inner join product on order_product.id_product=product.id
inner join `order` on order_product.id_order=`order`.id_order
group by id_order
order by date DESC");
    $table="<table><tr><td>№ заказа</td><td>Дата заказа</td><td>Всего товаров</td><td>Сумма заказа</td><td>Статус</td></tr>";
    while($value=$res->fetch()) {
        switch ($value['status']) {
            case 0:
                $status = "Выполняется";
                break;
            case 1:
                $status = "Завершен";
                break;
        }
        $table .= "<tr><td>" . $value['id_order'] . "</td><td>". $value['date'] ."<td>" . $value['allcount'] . "</td><td>" . $value['summ'] . "</td><td>$status</td>
<td><button id='button' onclick='changeOrderStatus(" . $value['id_order'] . ")'>Изменить</button></td></tr>";
    }
    $table.="</table>";
    return $table;
}
	
}