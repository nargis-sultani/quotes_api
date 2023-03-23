<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $item = new Author($db);

    $data = json_decode(file_get_contents("php://input"));
    //$data = json_decode('{"id": 20, "author":"my test author 20"}');

    $item->id = $data->id;

    // author values
    $item->author = $data->author;

    if($item->updateAuthor()){
        echo 'updated author (' . $data->id . ', ' . $data->author . ')';
    } else{
        echo json_encode(
            array("message:" => "author_id Not Found")
        );
    }
?>