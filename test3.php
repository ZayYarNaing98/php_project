<?php

include("vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;

$table = new UsersTable(new MySQL);
$table -> insert([
    "name" => "Tom",
    "email" => "tom@gmail.com",
    "phone" => "24304823",
    "address" => "address",
    "password" => "password",

]);

print_r($table->getAll());
