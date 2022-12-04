<?php

namespace Libs\Database;

use PDOExcepiton;

class RolesTable
{
    private $db;

    public function __construct(MYSQL $mysql)
    {
        $this->db = $mysql->connect();
    }

    public function getAll()
    {
        $result = $this->db->query("SELECT * FROM roles");
        return $result->fetchAll();
    }
}