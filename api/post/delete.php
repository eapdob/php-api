<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Instantiate DB & connect
include_once '../../config/Database.php';
include_once '../../models/Post.php';
$database = new Database();
$db = $database->connect();

// Instantiate Post
$post = new Post($db);

// Get post data
if (!empty($_POST) && !empty($_POST['id'])) {
    $post->id = htmlspecialchars(stripslashes(trim($_POST['id'])));
} elseif ($data = json_decode(file_get_contents("php://input"))) {
    $post->id = $data->id;
}

// Delete post
if ($post->delete()) {
    echo json_encode(['message' => 'Post Deleted']);
} else {
    echo json_encode(['message' => 'Post Not Deleted']);
}