<?php
/**
 * Created by PhpStorm.
 * User: Тимурка
 * Date: 30.11.2017
 * Time: 1:11
 */
include_once '../config/config.php';
require_once TWIG_DIR.'Autoloader.php';
Twig_Autoloader::register();
include_once CORE_DIR.'autoload.php';
Route::start();