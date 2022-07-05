<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Instantiate DB & connect
include_once '../../config/Database.php';
include_once '../../models/Category.php';
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);

// Category read query
$result = $category->read();

// Get row count
$num = $result->rowCount();

// Check if any categories
if ($num > 0) {
    $cat_arr = [];
    $cat_arr['data'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $cat_item = [
            'id' => $id,
            'name' => $name
        ];

        $cat_arr['data'][] = $cat_item;
    }

    echo json_encode($cat_arr);
} else {
    // No Categories
    echo json_encode(['message' => 'No Categories Found']);
}
