<?php

// FRONT CONTROLLER

// Общие настройки
ini_set('display_errors',1);
error_reporting(E_ALL);

//session_start();

// Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/components/Autoload.php');
require_once ROOT . '/PHPMailer/PHPMailer.php';
require_once ROOT . '/PHPMailer/Exception.php';
require_once ROOT . '/PHPMailer/SMTP.php';
// Вызов Router
$router = new Router();
$router->run();
