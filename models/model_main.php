<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 14:05
 */

class model_main extends Model
{
    public function getIndex()
    {
        $data=parent::getDefault();
        $db=db::connect();
        //$mysqli= new mysqli(SQL_SERVER,SQL_USER,SQL_PASS,dbname,SQL_PORT);
        $res = $db->query("select product.id,product.name, gallery.b_img from product inner join gallery on gallery.id=product.id limit 3");
        while($res_i=$res->fetch(PDO::FETCH_ASSOC)){
            $res_i['b_img']=GALLERY_DIR.$res_i['b_img'];
            if($res_i['id']==1){
                $res_i['style']="image_top";
                $result[]=$res_i;
            }
            else{
                $res_i['style']="image_bottom";
                $result[]=$res_i;
            }
        }
        try{
            $loader = new Twig_Loader_Filesystem(TPL_DIR);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate('index.tmpl');
            $content=$template->render(array('cont'=>$result));
            $data['content']=$content;
            $data['title']="Магазин комиксов";
            return $data;

        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
    }
    public function getPage($id)
    {
        $data=parent::getDefault();
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
        $res=$res->fetch(PDO::FETCH_ASSOC);
        $res['pers']=implode(',',$db->query("select persons.name from comics_char
inner join persons on persons.id_pers=comics_char.id_pers
where comics_char.id=$id")->fetch(PDO::FETCH_ASSOC));
        $res['b_img']=GALLERY_DIR.$res['b_img'];


         try{
            $data['review']=true;
            $loader = new Twig_Loader_Filesystem(TPL_DIR);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate('goods.tmpl');
            $data['content']=$template->render(array('page'=>$res,
                'id'=>$id));
        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
        $data['title']=$res['name'];
         return $data;


    }
}
