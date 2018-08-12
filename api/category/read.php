<?php
/**
 * Created by PhpStorm.
 * User: rimvydas
 * Date: 18.8.12
 * Time: 14.37
 */

//Headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instantiate DB and connection

$database = new Database();
$db = $database->connect();

//Instantiate blog post obj

$category = new Category($db);

$result = $category->getCategory();

$num = $result->getCount();

if ($num > 0){
    //Post arr
    $categories_arr = [];
    $categories_arr['data'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $category_item = [
            'id' => $id,
            'name' => $name,

        ];

        //Push to  data rr
        array_push($categories_arr['data'], $category_item);

    }
    //Turn it to json data
    echo json_encode($categories_arr);
}else {
    //No posts
    echo  json_encode(['message' => 'NO posts found']);
}