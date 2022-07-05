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

// Get id
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get post
$post->read_single();
$post_arr = [
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
];

print_r(json_encode($post_arr));