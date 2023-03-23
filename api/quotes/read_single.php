<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog category object
  $quote = new Quote($db);

  $quote->id = isset($_GET['id']) ? $_GET['id'] : die();

  //$quote->id = 10;
  $quote->getSingleQuoteById();
  if($quote->quote != null){
      // create array
      $quote_arr = array(
          "id" =>  $quote->id,
          "quote" => $quote->quote,
          "author" => $quote->author,
          "category" => $quote->category
      );

      http_response_code(200);
      echo json_encode($quote_arr);
  }

  else{
    http_response_code(404);
    echo json_encode(
        array("message" => 'No Quotes Found')
    );
  }
?>
