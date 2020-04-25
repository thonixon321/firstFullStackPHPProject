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

//Blog post query
$result = $post->read();
//Get row count
$num = $result->rowCount();
//Check if any posts
if($num > 0) {
  //Post array
  $posts_arr = array();

  $posts_arr['data'] = array();
  //get an associative array from result

  //loop through the result given from our model read method
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    //instead of accessing $row['title'] we can extract that same thing
    extract($row);

    $post_item = array(
      'id' => $id,
      'title' => $title,
      'body' => html_entity_decode($body),
      'author' => $author,
      'category_id' => $category_id,
      'category_name' => $category_name
    );

    //Push to data
    array_push($posts_arr['data'], $post_item);
  }

  // Turn to JSON & output
  echo json_encode($posts_arr);

}
else {
  //No Posts
  echo json_encode(
    array('message' => 'No Posts Found')
  );

}