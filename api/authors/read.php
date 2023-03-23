<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
    $database = new Database();
    $db = $database->connect();
    $items = new Author($db);

    if(isset($_GET['id'])){
        $items->id = $_GET['id'];
        $stmt =  $items->getSingleAuthorById();
    }
    else {
        $stmt = $items->getAuthors();
    }

    $itemCount = $stmt->rowCount();

    
    if($itemCount > 0){

        $authorArr = array();
        //$authorArr["body"] = array();
        //$authorArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "author" => $author,
            );
            array_push($authorArr, $e);
        }
        echo json_encode($authorArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>