<?php

namespace Core\Services;

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    public static function init()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');

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
    }
}
