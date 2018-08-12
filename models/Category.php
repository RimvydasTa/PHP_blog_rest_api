<?php
/**
 * Created by PhpStorm.
 * User: rimvydas
 * Date: 18.8.12
 * Time: 14.32
 */

class Category
{
    private $connection;
    private $table = 'categories';

    //Properties
    public $id;
    public $name;
    public $created_at;

    /**
     * Category constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function getCategory()
    {
        $query = 'select 
          categories.id, 
          categories.name 
          from' . $this->table . '
          order by created_at desc
          ';

        //Prepare statement
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}