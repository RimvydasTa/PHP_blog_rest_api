<?php
/**
 * Created by PhpStorm.
 * User: rimvydas
 * Date: 18.8.12
 * Time: 11.48
 */

class Post
{
    private $connection;
    private $table = 'posts';

    //Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    /**
     * Post constructor.
     * @param $db
     */
    public function __construct($db)
    {
        $this->connection = $db;
    }


    /**
     * @return mixed
     */
    public function getPosts()
    {
        $query = 'select
              c.name as category_name
                  p.id, 
                  p.category_id,
                  p.title,
                  p.body,
                  p.author,
                  p.created_at
                  from 
                  ' . $this->table . ' p
                  left join 
                    categories c on p.category_id = c.id
                    order by
                    p.created_at desc
        ';
        //Prepared statement
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;

    }
    //Get single post
    public function getSinglePost()
    {
         $query = 'select
              c.name as category_name
                  p.id, 
                  p.category_id,
                  p.title,
                  p.body,
                  p.author,
                  p.created_at
                  from 
                  ' . $this->table . ' p
                  left join 
                    categories c on p.category_id = c.id
                    where p.id = ?
                    limit 0,1
        ';

         $stmt = $this->connection->prepare($query);
         $stmt->bindParam(1, $this->id);
         $stmt->execute();

         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         //Set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    public function createPost()
    {
        //Create query
        $query = 'insert into  '.$this->table.'
        set 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id,
        
        ';

        //Prepare
        $stmt = $this->connection->prepare($query);

        //Clean submit data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            return true;
        }else {
            //Print error
            printf("Error: %s.\n", $stmt->error);
            return false;
        }


    }

    public function updatePost()
    {
        //Create query
        $query = 'update '.$this->table.'
        set 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id,
        where id = :id
        ';

        //Prepare
        $stmt = $this->connection->prepare($query);

        //Clean submit data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }else {
            //Print error
            printf("Error: %s.\n", $stmt->error);
            return false;
        }


    }

    public function deletePost()
    {
        $query = 'delete from '.$this->table.' where id = :id';
        //Prepare
        $stmt = $this->connection->prepare($query);
        //Clean id
        $this->id = htmlspecialchars(strip_tags($this->id));
        //Bind id
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }else {
            //Print error
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

}


