<?php
/**
 * Created by PhpStorm.
 * User: rimvydas
 * Date: 18.8.12
 * Time: 14.23
 */



header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB and connection

$database = new Database();
$db = $database->connect();

//Instantiate blog post obj

$post = new Post($db);header('Access-Control-Allow-Methods: PUT');
header(
    'Access-Control-Allow-Headers: 
    Access-Control-Allow-Headers, 
    Content-Type,
    Access-Control-Allow-Methods,
    Authorization,
    X-Requested-With
');

$data = json_decode(file_get_contents("php://input"));

// SET id to update
$post->id = $data->id;

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

if ($post->updatePost()){
    echo json_encode(
        [
            'message' => 'Post Updated'
        ]
    );
}else {
    echo json_encode(
        [
            'message' => 'Failed, error post not updated'
        ]
    );
}
