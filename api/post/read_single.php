<?php
/**
 * Created by PhpStorm.
 * User: rimvydas
 * Date: 18.8.12
 * Time: 13.52
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
//Get id

$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get single post
$post->getSinglePost();

//Create an array

$post_arr = [
    'id' => $post->id,
    'title' => $post->title,
    'body' => html_entity_decode($post->body),
    'author' => $post->author,
    'category_id' => $post->category_id,
    'created_name' =>  $post->category_name
];
 echo json_encode($post_arr);