<?php

require_once "vendor/autoload.php";

use Core\Libraries\Session;
use Core\Services\Database;

/* start session */
Session::init();
Session::set('auth', false);

/* init database */
Database::init();
