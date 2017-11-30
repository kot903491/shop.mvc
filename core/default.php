<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 14:41
 */
$style=array(
    'fb'=>STYLE_ICO.'facebook-logo.svg',
    'gp'=>STYLE_ICO.'google-plus-social-logotype.svg',
    'vk'=>STYLE_ICO.'vk-social-logotype.svg',
    'logo'=>STYLE_IMG.'logo.png',
    'placeholder'=>STYLE_ICO.'placeholder.svg',
    'envelope'=>STYLE_ICO.'envelope.svg',
    'phone'=>STYLE_ICO.'phone-call.svg',
    'css'=>STYLE_DIR.'style.css');
$ajax=array('jquery'=>'<script src="'.JS_DIR.'jquery.js"></script>',
    'basket_func'=>'<script src="'.JS_DIR.'basket.js"></script>',
    'review_func'=>'<script src="'.JS_DIR.'review.js"></script>',
    'catalog_func'=>'<script src="'.JS_DIR.'catalog.js"></script>');
$basket_view=true;
$review=false;
$catalog=false;
$data=array('footer'=>'footer.tmpl',
    'header'=>'header.tmpl',
    'style'=>$style,
    'ajax'=>$ajax,
    'basket_view'=>$basket_view,
    'review'=>$review,
    'catalog'=>$catalog);