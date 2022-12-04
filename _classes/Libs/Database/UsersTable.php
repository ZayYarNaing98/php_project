<?php

namespace Libs\Database;

use PDOException;

class UsersTable
{
    private $db;

    public function __construct(MySQL $mysql)
    {
        $this->db = $mysql -> connect();
    }

    public function insert($data)
    {
        $data['password']=password_hash($data['password'],PASSWORD_DEFAULT);
        try{
            $statement = $this->db->prepare("
                INSERT INTO users (name, email, phone,
                address, password, created_at) VALUES 
                (:name, :email, :phone, :address, :password, NOW())
            ");

            $statement -> execute($data);

            return $this -> db ->lastInsertId();
        }catch(PDOException $e){
            echo $e -> getMessage();
            exit();
        }
    }

    public function getAll()
    {

        try{

            $result = $this->db->query("
                SELECT users.*, roles.name AS role,
                roles.value 
                FROM users LEFT JOIN roles 
                ON users.role_id = roles.id
            ");

            return $result -> fetchALL();

        }catch(PDOException $e){
            echo $e -> getMessage();
            exit();
        }         
    }

    public function findByEmailAndPassword($email, $password)
    {
        $statement = $this->db->prepare("
        SELECT users.*, roles.name As role, roles.value
        FROM users LEFT JOIN roles
        ON users.role_id = roles.id
        WHERE users.email = :email
        ");

        $statement-> execute([':email'=>$email]);

        $row = $statement->fetch();

        if($row){
            if(password_verify($password, $row->password)){
                return $row;
            }
        }

        $row = $statement->fetch();

        return $row ?? false;
    }

    public function suspend($id)
    {
        try{
            $statement = $this->db->prepare("UPDATE users SET suspended=1 WHERE id=:id");
            $statement -> execute(['id'=>$id]);

            return $statement->rowCount();

        }catch(PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }


    public function unsuspend($id)
    {
        try{
            $statement = $this->db->prepare("UPDATE users SET suspended=0 WHERE id=:id");
            $statement -> execute(['id'=>$id]);

            return $statement->rowCount();

        }catch(PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }


    public function delete($id)
    {
        try{
            $statement = $this->db->prepare("DELETE FROM users WHERE id= :id");
            $statement -> execute(['id'=>$id]);

            return $statement->rowCount();

        }catch(PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }

    public function role($id, $role)
    {
        try{
            $statement = $this->db->prepare("UPDATE users SET role_id=:role WHERE id=:id");
            $statement -> execute(['id'=>$id, 'role'=>$role]);

            return $statement->rowCount();

        }catch(PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }

    public function updatePhoto($id, $name)
    {
        $statement = $this->db->prepare("
        UPDATE users 
        SET photo=:name
        WHERE id=:id");
        $statement->execute([
            ':name'=>$name ,':id'=>$id
        ]);
        return $statement->rowCount();
    }

}