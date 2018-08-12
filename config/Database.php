<?php
/**
 * Created by PhpStorm.
 * User: rimvydas
 * Date: 18.8.12
 * Time: 11.41
 */

class Database
{
    // DB params
    private $host = 'localhost';
    private $db_name = 'myblog';
    private $username = 'root';
    private $password = '';
    private $connection;

    //DB connection

    public function connect()
    {
        $this->connection = null;

        try {
            $this->connection = new PDO('mysql:host='
                . $this->host.
                ';dbname=' .
                $this->db_name,
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e){
            echo  'Connection error' .  $e->getMessage();
        }
        return $this->connection;
    }
}