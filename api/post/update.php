<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Instantiate DB & connect
include_once '../../config/Database.php';
include_once '../../models/Post.php';
$database = new Database();
$db = $database->connect();

// Instantiate Post
$post = new Post($db);

// Get post data
if (!empty($_POST) &&
    !empty($_POST['id']) &&
    !empty($_POST['title']) &&
    !empty($_POST['body']) &&
    !empty($_POST['author']) &&
    !empty($_POST['category_id'])) {
    $post->id = htmlspecialchars(stripslashes(trim($_POST['id'])));
    $post->title = htmlspecialchars(stripslashes(trim($_POST['title'])));
    $post->body = htmlspecialchars(stripslashes(trim($_POST['body'])));
    $post->author = htmlspecialchars(stripslashes(trim($_POST['author'])));
    $post->category_id = htmlspecialchars(stripslashes(trim($_POST['category_id'])));
} elseif ($data = json_decode(file_get_contents("php://input"))) {
    $post->id = $data->id;
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;
}

// Update post
if ($post->update()) {
    echo json_encode(['message' => 'Post Updated']);
} else {
    echo json_encode(['message' => 'Post Not Updated']);
}