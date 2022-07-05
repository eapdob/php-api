<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Instantiate DB & connect
include_once '../../config/Database.php';
include_once '../../models/Post.php';
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$post = new Post($db);

// Get post data
if (!empty($_POST) &&
    !empty($_POST['title']) &&
    !empty($_POST['body']) &&
    !empty($_POST['author']) &&
    !empty($_POST['category_id'])) {
    $post->title = htmlspecialchars(stripslashes(trim($_POST['title'])));
    $post->body = htmlspecialchars(stripslashes(trim($_POST['body'])));
    $post->author = htmlspecialchars(stripslashes(trim($_POST['author'])));
    $post->category_id = htmlspecialchars(stripslashes(trim($_POST['category_id'])));
} elseif ($data = json_decode(file_get_contents("php://input"))) {
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;
}

// Create post
if ($post->create()) {
    echo json_encode(['message' => 'Post Created']);
} else {
    echo json_encode(['message' => 'Post Not Created']);
}