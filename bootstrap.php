<?php

require_once "vendor/autoload.php";

use Core\Libraries\Session;
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

Session::init();
Session::set('auth', false);



$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $_ENV['DB_HOST'],
    'database'  => $_ENV['DB_NAME'],
    'username'  => $_ENV['DB_USER'],
    'password'  => $_ENV['DB_PASS'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
