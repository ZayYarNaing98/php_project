<?php

include("vendor/autoload.php");

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;

$auth = new Auth;
$auth->check();
echo"<br>";
echo HTTP::$url;
echo"<br>";
$mysql = new MySQL;
$mysql->connect();
echo"<br>";
$table = new UsersTable;
$table->getAll();


// pg-587



