<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog category object
  $category = new Category($db);

  // Get ID
  $category->id = isset($_GET['id']) ? $_GET['id'] : die();

  //$category->id = 5;
  $category->getSingleCategoryById();
  if($category->category != null){
      // create array
      $category_arr = array(
          "id" =>  $category->id,
          "category" => $category->category
      );

      http_response_code(200);
      echo json_encode($category_arr);
  }

  else{
    http_response_code(404);
    echo json_encode(
        array("message" => 'category_id Not Found')
    );
  }


?>
