<?php

require_once "vendor/autoload.php";

use Core\Libraries\Session;
use Core\Services\Database;
use Dotenv\Dotenv;

/* load environment variables */
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/* start session */
Session::init();
Session::set('auth', false);

/* init database */
Database::init();
