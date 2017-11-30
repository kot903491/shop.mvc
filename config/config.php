<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 1:05
 */
$s=dirname(__FILE__);
define('_DS', DIRECTORY_SEPARATOR);
define('SITE_ROOT', '..'._DS);
define('SITE_DIR',SITE_ROOT.'public'._DS);

define('SQL_SERVER','localhost');
define('SQL_USER','root');
define('SQL_PASS','12345');
define('SQL_PORT','3306');
define('dbname','comics_shop');

define('CORE_DIR',SITE_ROOT.'core'._DS);


define('GALLERY_DIR', _DS.'public'._DS.'galery'._DS);
define('LIB_DIR', SITE_ROOT . 'lib'._DS);
define('MODEL_DIR',SITE_ROOT.'models'._DS);
define('JS_DIR', _DS.'js'._DS);
define('CLASS_DIR',SITE_ROOT.'classes'._DS);
define('TWIG_DIR',SITE_ROOT.'Twig'._DS);
define('TPL_DIR', SITE_ROOT . 'tmpl'._DS);
define('STYLE_DIR',_DS.'public'._DS.'style'._DS);
define('STYLE_IMG',STYLE_DIR.'img'._DS);
define('STYLE_ICO',STYLE_DIR.'icons'._DS);
define('ADMIN_DIR',TPL_DIR.'admin'._DS);
define('ADMIN_TPL',ADMIN_DIR.'tpl'._DS);
define('AUTH_DIR',ADMIN_DIR.'auth'._DS);
define('sult_cookie','cvfjee59889eg7h43wglujuj8ijhrt4frui8o');
date_default_timezone_set('Asia/Aqtobe');
