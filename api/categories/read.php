<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    $database = new Database();
    $db = $database->connect();
    $items = new Category($db);
    if(isset($_GET['id'])){
        $items->id = $_GET['id'];
        $stmt =  $items->getSingleCategoryById();
    }
    else {
        $stmt = $items->getCategories();
    }
    $itemCount = $stmt->rowCount();

    
    if($itemCount > 0){

        $categoryArr = array();
        //$categoryArr["body"] = array();
        //$categoryArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "category" => $category,
            );
            array_push($categoryArr, $e);
        }
        echo json_encode($categoryArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>