<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog category object
  $author = new Author($db);

  // Get ID
  $author->id = isset($_GET['id']) ? $_GET['id'] : die();

  //$author->id = 5;
  $author->getSingleAuthorById();
  if($author->author != null){
      // create array
      $author_arr = array(
          "id" =>  $author->id,
          "author" => $author->author
      );

      http_response_code(200);
      echo json_encode($author_arr);
  }

  else{
    http_response_code(404);
    echo json_encode(
        array("message" => 'author_id Not Found')
    );
  }


?>
