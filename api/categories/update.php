<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $item = new Category($db);

    $data = json_decode(file_get_contents("php://input"));
    //$data = json_decode('{"id": 8, "category":"my test category 8"}');

    $item->id = $data->id;

    // author values
    $item->category = $data->category;

    if($item->updateCategory()){
        echo 'updated category (' . $data->id . ', ' . $data->category . ')';
    } else{
        echo json_encode(
            array("message:" => "category_id Not Found")
        );
    }
?>