<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 01.12.2017
 * Time: 1:06
 */

class model_page extends Model
{
    public function getCatalog()
    {
        try{
            $this->data['catalog']=true;
            $loader = new Twig_Loader_Filesystem(TPL_DIR);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate('catalog.tmpl');
            $this->data['content']=$template->render(array());
        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
        $this->data['title'] = "Каталог комиксов";
        return $this->data;
    }
    public function getGood($id)
    {
        $db=db::connect();
        $res=$db->query("select product.name,product.autor,product.painter,product.pages,
product.price, desk.f_desk, gallery.b_img,binding.name as bind,
publ_origin.publ as publ_o,publ_local.publ as publ_l FROM product
inner join desk on desk.id=product.id
inner join gallery on gallery.id=product.id
inner join publishing on publishing.id=product.id
inner join publ_origin on publ_origin.id_publ=publishing.id_publ_o
inner join publ_local on publ_local.id_publ=publishing.id_publ_l
inner join binding on binding.id_bin=publishing.id_bin
where product.id=$id");
        $res=$res->fetch();
        $res['pers']=implode(',',$db->query("select persons.name from comics_char
inner join persons on persons.id_pers=comics_char.id_pers
where comics_char.id=$id")->fetch());
        $res['b_img']=GALLERY_DIR.$res['b_img'];
        try{
            $this->data['review']=true;
            $loader = new Twig_Loader_Filesystem(TPL_DIR);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate('goods.tmpl');
            $this->data['content']=$template->render(array('page'=>$res,
                'id'=>$id));
        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
        $this->data['title']=$res['name'];
        return $this->data;
    }
    public function getAbout(){
        try{
            $loader = new Twig_Loader_Filesystem(TPL_DIR);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate('about.tmpl');
            $content=$template->render(['style'=>$this->data['style']]);
            $this->data['content']=$content;
            $this->data['title']="Магазин комиксов";
            return $this->data;
        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
    }
    public function getBasket(){
        if ($_POST['name'] != '' && $_POST['tel'] != '' && $_POST['address'] != '') {
            Basket::setOrder($_POST);
        } else {
            $basket = unserialize($_COOKIE['basket_product']);
            if (!$basket) {
                $msg = "Корзина пуста";
            } else {
                $msg = "Редактирование и оформление заказа";
            }
            try{
                $loader = new Twig_Loader_Filesystem(TPL_DIR);
                $twig=new Twig_Environment($loader);
                $template=$twig->loadTemplate('basket.tmpl');
                $content=$template->render(array('msg'=>$msg));
                $this->data['content']=$content;
                $this->data['title']="Магазин комиксов";
                return $this->data;
            }
            catch (Exception $e){
                die('ERROR: '.$e->getMessage());
            }

            $title = "Корзина";
        }
    }
}