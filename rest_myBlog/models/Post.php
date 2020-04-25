<?php

class Post {
  private $conn;
  private $table = 'posts';

  //Post Properties
  public $id;
  public $category_id;
  public $category_name;
  public $title;
  public $body;
  public $author;
  public $created_at;

  //Constructor with DB (auto runs when calling class)
  //when we initialise a new post, we pass in the DB object (config file)
  public function __construct($db) {
    $this->conn = $db;
  }

  //Get Posts (read them)
  public function read() {
    //Create query -
    //using alias to join posts table with categories table -
    //to get the category name from the categories table -
    //c. is the alias for categories table and p. is alias for posts table -
    //Left join is where we bring in another table -
    //stating that we do this where the ids match and gives us the category name
    //that matches up with that id correlation between the tables
    $query = 'SELECT
      c.name as category_name,
      p.id,
      p.category_id,
      p.title,
      p.body,
      p.author,
      p.created_at
      FROM
        ' . $this->table . ' p
      LEFT JOIN
        categories c ON p.category_id = c.id
      ORDER BY
        p.created_at DESC';

    //Prepare statement (PDO)
    $stmt = $this->conn->prepare($query);

    //Execute query
    $stmt->execute();

    return $stmt;
  }


  //Get Single Post
  public function read_single() {
    $query = 'SELECT
      c.name as category_name,
      p.id,
      p.category_id,
      p.title,
      p.body,
      p.author,
      p.created_at
      FROM
        ' . $this->table . ' p
      LEFT JOIN
        categories c ON p.category_id = c.id
      WHERE
        p.id = ?
      LIMIT 0,1';

    //Prepare statement (PDO)
    $stmt = $this->conn->prepare($query);

    //Bind ID (only 1 param so id so use 1 for first query param)
    $stmt->bindParam(1, $this->id);

    //Execute query
    $stmt->execute();

    //fetch the array from query instead of dumping the whole query
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //Set properties from the associative array we are getting in $row
    $this->title = $row['title'];
    $this->body = $row['body'];
    $this->author = $row['author'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];

  }

  //create post
  public function create() {
    //create query
    $query = 'INSERT INTO posts
      SET
        title = :title,
        body = :body,
        author = :author,
        category_id = :category_id';

    //prepare statement
    $stmt = $this->conn->prepare($query);

    //clean data
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));

    //Bind data
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->category_id);

    //execute query
    //if everything executes okay, return true
    if($stmt->execute()) {
      return true;
    }

    //print error if something goes wrong
    //%s is a placeholder, and \n is new line
    printf("Error: %s.\n", $stmt->error);

    return false;
  }


   //update post
   public function update() {
    //create query
    $query = 'UPDATE posts
      SET
        title = :title,
        body = :body,
        author = :author,
        category_id = :category_id
      WHERE
        id = :id';

    //prepare statement
    $stmt = $this->conn->prepare($query);

    //clean data
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->id = htmlspecialchars(strip_tags($this->id));

    //Bind data
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':id', $this->id);

    //execute query
    //if everything executes okay, return true
    if($stmt->execute()) {
      return true;
    }

    //print error if something goes wrong
    //%s is a placeholder, and \n is new line
    printf("Error: %s.\n", $stmt->error);

    return false;
  }


  //delete post
  public function delete() {
    //create query
    $query = 'DELETE FROM posts WHERE id = :id';

    //prepare statement
    $stmt = $this->conn->prepare($query);
    //clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    //bind id
    $stmt->bindParam(':id', $this->id);

    if($stmt->execute()) {
      return true;
    }

    //print error if something goes wrong
    //%s is a placeholder, and \n is new line
    printf("Error: %s.\n", $stmt->error);

    return false;
  }


}