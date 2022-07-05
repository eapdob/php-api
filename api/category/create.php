<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

// Instantiate DB & connect
include_once '../../config/Database.php';
include_once '../../models/Category.php';
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$category = new Category($db);

// Get post data
if (!empty($_POST) && !empty($_POST['name'])) {
    $category->name = htmlspecialchars(stripslashes(trim($_POST['name'])));
} elseif ($data = json_decode(file_get_contents("php://input"))) {
    $category->name = $data->name;
}

// Create Category
if ($category->create()) {
    echo json_encode(['message' => 'Category Created']);
} else {
    echo json_encode(['message' => 'Category Not Created']);
}