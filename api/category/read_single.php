<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Instantiate DB & connect
include_once '../../config/Database.php';
include_once '../../models/Category.php';
$database = new Database();
$db = $database->connect();

// Instantiate blog category object
$category = new Category($db);

// Get id
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get category
if ($category->read_single()) {
    $category_arr = [
        'id' => $category->id,
        'name' => $category->name
    ];

    print_r(json_encode($category_arr));
} else {
    echo json_encode(['message' => 'Category doesn\'t exist']);
}