<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $quote = new Quote($db);
   

    $data = json_decode(file_get_contents("php://input"));
    //$data= json_decode('{"quote":"my test quote","author_id":4,"category_id":50}');
    $required = array('quote', 'author_id', 'category_id');

    $error = false;
    //echo json_encode($error);
    foreach($required as $field) {
       
        if ($data->$field != null) {

            $error = true;
        }
    }
    //echo json_encode($error);

    if (json_encode($error) == false) {
        echo json_encode(
            array("message:" => "Missing Required Parameters")
        );
    } 
    else {
        $quote->quote = $data->quote;
        $quote->author_id = $data->author_id;
        $quote->category_id = $data->category_id;

        if ($quote->doesAuthorExist() && $quote->doesCategoryExist()){

            if($quote->createQuote()){
                echo 'created quote (' . $quote->id . ', ' . $data->quote . ', ' . $data->author_id . ', ' . $data->category_id .  ')';
            } else{
                echo 'Quote could not be created.';
            }

        }
        else {
            if ($quote->doesAuthorExist() == false){
                echo json_encode(
                    array("message:" => "author_id Not Found")
                ); 
            }
            if ($quote->doesCategoryExist() == false){
                echo json_encode(
                    array("message:" => "category_id Not Found")
                ); 
            }
        }
    }

?>