<?php
/**
 * Created by PhpStorm.
 * User: rimvydas
 * Date: 18.8.12
 * Time: 14.06
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
header('Access-Control-Allow-Methods: POST');
header(
    'Access-Control-Allow-Headers: 
    Access-Control-Allow-Headers,
    Content-Type,
    Access-Control-Allow-Methods,
    Authorization,
    X-Requested-With
');

$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

if ($post->createPost()){
    echo json_encode(
        [
            'message' => 'Post Created'
        ]
    );
}else {
    echo json_encode(
        [
            'message' => 'Failed, error post not created'
        ]
    );
}
