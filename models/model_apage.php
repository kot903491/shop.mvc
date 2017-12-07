<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 08.12.2017
 * Time: 0:03
 */

class model_apage extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->adminData();
    }

    public function Login(){
        $data=model_admin::adminLoginPage();
        $this->data['content']=$data['content'];
        $this->data['title']=$data['title'];
        return $this->data;
    }

    public function getBasket(){
        try {
            $loader = new Twig_Loader_Filesystem(ADMIN_TPL);
            $twig = new Twig_Environment($loader);
            $template = $twig->loadTemplate('admin_basket.tmpl');
            $this->data['content'] = $template->render(['getBasketTable'=>Basket::getBasketTable()]);
            $this->data['header'] = 'admin_header.tmpl';
            $this->data['path'] = ADMIN_TPL;
            $this->data['tmpl'] = 'admin_main.tmpl';
            $this->data['title'] = "Админка-корзина";
            return $this->data;
        } catch (Exception $e) {
            die('ERROR: ' . $e->getMessage());

        }
    }

    public function getAdd()
    {
        if (isset($_POST['submit'])) {
            ActionGood::addNew($_POST);
        }
        try {
            $loader = new Twig_Loader_Filesystem(ADMIN_TPL);
            $twig = new Twig_Environment($loader);
            $template = $twig->loadTemplate('admin_goods.tmpl');
            $this->data['content'] = $template->render(['check' => ActionGood::getNew()]);
            $this->data['header'] = 'admin_header.tmpl';
            $this->data['path'] = ADMIN_TPL;
            $this->data['tmpl'] = 'admin_main.tmpl';
            $this->data['title'] = "Админка-добавление";
            return $this->data;
        } catch (Exception $e) {
            die('ERROR: ' . $e->getMessage());
        }

    }

    public function getCatalog()
    {
        $db = DB::connect();
        $res = $db->query("select product.id,product.name, desk.s_desk, gallery.s_img FROM product inner join desk on desk.id=product.id inner join gallery on gallery.id=product.id");
        while ($res_all = $res->fetch()) {
            $res_all['s_img'] = GALLERY_DIR . $res_all['s_img'];
            $result[] = $res_all;
        }
        try{
            $url=array('edit'=>'/apage/edit/',
                'delete'=>'/apage/delete/');
            $loader = new Twig_Loader_Filesystem(ADMIN_TPL);
            $twig=new Twig_Environment($loader);
            $template=$twig->loadTemplate('admin_catalog.tmpl');
            $this->data['content']=$template->render(array('cont'=>$result,
                'url'=>$url));
            $this->data['header'] = 'admin_header.tmpl';
            $this->data['path'] = ADMIN_TPL;
            $this->data['tmpl'] = 'admin_main.tmpl';
            $this->data['title'] = "Админка-каталог";
            return $this->data;
        }
        catch (Exception $e){
            die('ERROR: '.$e->getMessage());
        }
    }

    public function getDelete($id)
    {
        $db=DB::connect();
        $res=$db->query('SELECT s_img,b_img FROM gallery WHERE id='.$id);
        $res=$res->fetch();
        $stmt=$db->prepare("DELETE FROM product WHERE id=?");
        $stmt->execute([$id]);
        if($res) {
            foreach ($res as $value) {
                if(file_exists(UPLOADED_DIR . $value)) {
                    unlink(UPLOADED_DIR . $value);
                }
            }
        }
        header("Refresh: 0; /apage/catalog/");
        die();
    }
}