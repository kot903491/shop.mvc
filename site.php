<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 05.12.2017
 * Time: 19:17
 */
require_once '../config/config.php';
require_once TWIG_DIR.'Autoloader.php';
Twig_Autoloader::register();
include_once CORE_DIR.'autoload.php';
Route::start();