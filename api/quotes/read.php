<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    $database = new Database();
    $db = $database->connect();
    $quotes = new Quote($db);


    if (count($_GET) > 1){
        if (isset($_GET['author_id'], $_GET['category_id'])) {
            $quotes->author_id = $_GET['author_id'];
            $quotes->category_id = $_GET['category_id'];
            //$quote->author_id = 5;
            //$quote->category_id = 4;
            $stmt = $quotes->getQuotesByCategoryAndAuthorId();
            $itemCount = $stmt->rowCount();
        }
    }
    else {
        if(isset($_GET['author_id'])) {
            $quotes->author_id = $_GET['author_id'];
            $stmt = $quotes->getQuotesByAuthorId();
            $itemCount = $stmt->rowCount();
        }
        elseif(isset($_GET['id'])){
            $quotes->id = $_GET['id'];
            $stmt =  $quotes->getSingleQuoteById();
            $itemCount = $stmt->rowCount();
        }
        elseif(isset($_GET['category_id'])) {
            $quotes->category_id = $_GET['category_id'];
            $stmt =  $quotes->getQuotesByCategoryId();
            $itemCount = $stmt->rowCount();
        }
        
        else {
            $stmt = $quotes->getQuotes();
            $itemCount = $stmt->rowCount();
        }
    }
    
    


    
    if($itemCount > 0){

        $quoteArr = array();
        //$quoteArr["body"] = array();
        //$quoteArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "quote" => $quote,
                "author" => $author,
                "category" => $category
            );
            //array_push($quoteArr["body"], $e);
            array_push($quoteArr, $e);
        }
        echo json_encode($quoteArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => 'No Quotes Found')
        );
    }
    

    
?>