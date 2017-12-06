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
        $db=db::connect();
        $res = $db->query("select product.id,product.name, gallery.b_img from product inner join gallery on gallery.id=product.id limit 3");
        while($res_i=$res->fetch()){
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
            $this->data['content']=$content;
            $this->data['title']="Магазин комиксов";
            return $this->data;
        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
    }
}
