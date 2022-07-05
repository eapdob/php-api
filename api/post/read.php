<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Instantiate DB & connect
include_once '../../config/Database.php';
include_once '../../models/Post.php';
$database = new Database();
$db = $database->connect();

// Instantiate Post
$post = new Post($db);

// Read post
$result = $post->read();

// Get row count
$num = $result->rowCount();

// Check if any posts
if ($num > 0) {
    $posts_arr = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = [
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        ];

        $posts_arr[] = $post_item;
    }

    echo json_encode($posts_arr);
} else {
    // No Posts
    echo json_encode(['message' => 'No Posts Found']);
}
