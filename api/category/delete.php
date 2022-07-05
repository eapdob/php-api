<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

// Instantiate DB & connect
include_once '../../config/Database.php';
include_once '../../models/Category.php';
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$category = new Category($db);

// Get post data
if (!empty($_POST) && !empty($_POST['id'])) {
    $category->id = htmlspecialchars(stripslashes(trim($_POST['id'])));
} elseif ($data = json_decode(file_get_contents("php://input"))) {
    $category->id = $data->id;
}

// Delete post
if ($category->delete()) {
    echo json_encode(['message' => 'Category deleted']);
} else {
    echo json_encode(['message' => 'Category not deleted']);
}