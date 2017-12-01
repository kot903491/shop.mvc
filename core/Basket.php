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
}