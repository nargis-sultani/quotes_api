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

    //$data = json_decode('{"id": 22}');
    $item->id = $data->id;

    if($item->deleteCategory()){
        echo json_encode($data->id . ' deleted.');
    } else{
        echo json_encode($data->id . ' could not be deleted.');
    }
?>