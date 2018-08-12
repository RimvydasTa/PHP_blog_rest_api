<?php
/**
 * Created by PhpStorm.
 * User: rimvydas
 * Date: 18.8.12
 * Time: 12.05
 */

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB and connection

$database = new Database();
$db = $database->connect();

//Instantiate blog post obj

$post = new Post($db);

//Blog post query
$result = $post->getPosts();
//Get row count
$num = $result->rowCount();

//Check if any posts
if ($num > 0){
    //Post arr
    $posts_arr = [];
    $posts_arr['data'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = [
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'created_name' =>  $category_name
        ];

        //Push to  data rr
        array_push($posts_arr['data'], $post_item);

    }
    //Turn it to json data
   echo json_encode($posts_arr);
}else {
    //No posts
    echo  json_encode(['message' => 'NO posts found']);
}