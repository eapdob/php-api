<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

// Instantiate DB & connect
include_once '../../config/Database.php';
include_once '../../models/Category.php';
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$category = new Category($db);

// Get post data
if (!empty($_POST) && !empty($_POST['id']) && !empty($_POST['name'])) {
    $category->id = htmlspecialchars(stripslashes(trim($_POST['id'])));
    $category->name = htmlspecialchars(stripslashes(trim($_POST['name'])));
} elseif ($data = json_decode(file_get_contents("php://input"))) {
    $category->id = $data->id;
    $category->name = $data->name;
}

// Update category
if ($category->update()) {
    echo json_encode(['message' => 'Category Updated']);
} else {
    echo json_encode(['message' => 'Category not updated']);
}