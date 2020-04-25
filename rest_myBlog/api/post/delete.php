<?php

//THIS ENDPOINT READS ALL THE DATA IN POSTS TABLE

//Headers (required for http request)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Post($db);

//Get raw posted data
// $data = json_decode(file_get_contents("php://input"));
if (isset($_POST['id'])) {
  $post->id = $_POST['id'];
}


//Update post
if($post->delete()) {
  echo json_encode(
    array('message' => 'Post Deleted')
  );
}
else{
  echo json_encode(
    array('message' => 'Post Not Deleted')
  );
}