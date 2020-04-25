<?php

//THIS ENDPOINT READS ALL THE DATA IN POSTS TABLE

//Headers (required for http request)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Post($db);

//Get ID (use the super global GET and check if it is set 'isset')
//e.g. something.com?id=3 - we can access the 3 here -
//it comes from the url, not the post model -
//and if it doesn't exist, then we kill the request
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get post
$post->read_single();

//Create array
$post_arr = array(
  'id' => $post->id,
  'title' => $post->title,
  'body' => $post->body,
  'category_id' => $post->category_id,
  'category_name' => $post->category_name,
  'author' => $post->author
);

//Make JSON
print_r(json_encode($post_arr));