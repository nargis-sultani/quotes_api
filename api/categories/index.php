<?php
$method = $_SERVER['REQUEST_METHOD'];

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    require 'read.php';
}
elseif($_SERVER['REQUEST_METHOD'] == 'POST'){
    require 'create.php';
}
elseif($_SERVER['REQUEST_METHOD'] == 'PUT'){
    require 'update.php';
}
elseif($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    require 'delete.php';
}

?>