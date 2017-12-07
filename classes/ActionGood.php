<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 08.12.2017
 * Time: 0:29
 */
class ActionGood
{
    function getNew(){
        $db=DB::connect();
        $result=['publ_o'=>[],'publ_l'=>[],'pers'=>[],'bind'=>[]];
        $res=$db->query("SELECT * FROM publ_origin");
        while($row=$res->fetch()){
            array_push($result['publ_o'],$row);
        }
        $res=$db->query("SELECT * FROM publ_local");
        while($row=$res->fetch()){
            array_push($result['publ_l'],$row);
        }
        $res=$db->query("SELECT * FROM persons");
        while($row=$res->fetch()){
            array_push($result['pers'],$row);
        }
        $res=$db->query("SELECT * FROM binding");
        while($row=$res->fetch()){
            array_push($result['bind'],$row);
        }
        return $result;
    }

    function addNew($data){
        $db=DB::connect();
        $stmt=$db->prepare("INSERT INTO product(name,autor,painter,pages,price) VALUES(?,?,?,?,?)");
        $stmt->execute([$data['name'],$data['autor'],$data['paint'],$data['pages'],$data['price']]);
        $i=$db->lastInsertId();
        $stmt=$db->prepare("INSERT INTO publishing(id,id_publ_o,id_publ_l,id_bin) VALUES(?,?,?,?)");
        $stmt->execute([$i,$data['publ_o'],$data['publ_l'],$data['bind']]);
        $stmt=$db->prepare("INSERT INTO comics_char(id,id_pers) VALUES(?,?)");
        foreach ($data['pers'] as $value) {
            $value=(int)$value;
            $stmt->execute([$i, $value]);
        }
        $type = explode(".", $_FILES['images']['name']);
        $b_img="CS_$i.".$type[1];
        $s_img="CS_".$i."_s.".$type[1];
        $b_path=UPLOADED_DIR.$b_img;
        $s_path=UPLOADED_DIR.$s_img;
        if (move_uploaded_file($_FILES['images']['tmp_name'], UPLOADED_DIR.$b_img)) {
            self::create_thumb($b_path, $s_path, 180, 230);
            $data['b_img'] = $b_img;
            $data['s_img'] = $s_img;
            $stmt=$db->prepare("INSERT INTO gallery(id,s_img,b_img) VALUES(?,?,?)");
            $stmt->execute([$i,$data['s_img'],$data['b_img']]);
        }
        $stmt=$db->prepare("INSERT INTO desk(id,s_desk,f_desk) VALUES(?,?,?)");
        $stmt->execute([$i,$data['s_desk'],$data['f_desk']]);
    }



    private function create_thumb($path, $save, $width, $height) {
        $info = getimagesize($path); //получаем размеры картинки и ее тип
        $size = array($info[0], $info[1]); //закидываем размеры в массив
//В зависимости от расширения картинки вызываем соответствующую функцию
        if ($info['mime'] == 'image/png') {
            $src = imagecreatefrompng($path); //создаём новое изображение из файла
        } else if ($info['mime'] == 'image/jpeg') {
            $src = imagecreatefromjpeg($path);
        } else if ($info['mime'] == 'image/gif') {
            $src = imagecreatefromgif($path);
        } else {
            return false;
        }
        $thumb = imagecreatetruecolor($width, $height); //возвращает идентификатор изображения, представляющий черное изображение заданного размера
        $src_aspect = $size[0] / $size[1]; //отношение ширины к высоте исходника
        $thumb_aspect = $width / $height; //отношение ширины к высоте аватарки
        if($src_aspect < $thumb_aspect) {
//узкий вариант (фиксированная ширина)
            $scale = $width / $size[0];
            $new_size = array($width, $width / $src_aspect);
            $src_pos = array(0, ($size[1] * $scale - $height) / $scale / 2);
//Ищем расстояние по высоте от края картинки до начала картины после обрезки
        }
        else if ($src_aspect > $thumb_aspect) {
//широкий вариант (фиксированная высота)
            $scale = $height / $size[1];
            $new_size = array($height * $src_aspect, $height);
            $src_pos = array(($size[0] * $scale - $width) / $scale / 2, 0); //Ищем расстояние по ширине от края картинки до начала картины после обрезки
        } else {
//другое
            $new_size = array($width, $height);
            $src_pos = array(0,0);
        }
        $new_size[0] = max($new_size[0], 1);
        $new_size[1] = max($new_size[1], 1);
        imagecopyresampled($thumb, $src, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $size[0], $size[1]);
//Копирование и изменение размера изображения с ресемплированием

        if($save === false) {
            return imagepng($thumb); //Выводит JPEG/PNG/GIF изображение
        } else {
            return imagepng($thumb, $save);//Сохраняет JPEG/PNG/GIF изображение
        }
    }
}