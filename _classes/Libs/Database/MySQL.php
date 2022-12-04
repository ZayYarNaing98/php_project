<?php

namespace Libs\Database;

use PDO;
use PDOException;

class MySQL
{

    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;
    private $db;

    public function __construct(
        $dbhost="localhost",
        $dbuser="root",
        $dbpass="",
        $dbname="project2",
    )
    {
        $this -> dbhost= $dbhost;
        $this -> dbuser= $dbuser;
        $this -> dbpass= $dbpass;
        $this -> dbname= $dbname;
        $this -> db = null;

    }


    public function connect()
    {
        try{
            $this -> db = new PDO(
                "mysql:dbhost=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass,[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]);
            return $this->db;
        }catch(PDOException $e){
            echo $e -> getMessage();
            exit();
        }
        // echo "MySQL class";
    }
}