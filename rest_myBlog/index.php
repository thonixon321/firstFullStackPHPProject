<?php



?>

<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>phpRestPractice</title>
</head>
<style>
  body {
    margin: 3em;
  }
  .posts {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
  }
  .postContainer, .singlePostContainer {
    padding: 1em;
    border: 1px solid black;
    max-width: 25em;
    margin: 1em;
    cursor: pointer;
    transition: .3s ease-in-out;
  }
  .postContainer:hover {
    transform: scale(1.051)
  }
  .postContainer.enlargen {
    width: 40em;
  }
  p.catName {
    font-style: italic;
  }
  div.field {
    display: flex;
    flex-direction: column;
    margin: .5em;
  }
  div.hide {
    display: none;
  }
</style>
<body>

<a class='createPost' href='#'>Create a post</a>

<h1 class='pageTitle'>All Posts:</h1>

<div class='createPostForm hide'>
  <form>
    <div class='field'>
      <label for='categoryType'>Category:</label>
      <select name='categoryType' id='categoryType'>
        <option value=''>Select Category</option>
        <option value='1'>Technology</option>
        <option value='2'>Gaming</option>
        <option value='3'>Auto</option>
        <option value='4'>Entertainment</option>
        <option value='5'>Books</option>
      </select>
    </div>

    <div class='field'>
      <label for='title'>Title:</label>
      <input type='text' id="title">
    </div>

    <div class='field'>
      <label for='textBody'>Body:</label>
      <textarea name='textBody' id='textBody' cols='30' rows='10'></textarea>
    </div>

    <div class='field'>
      <label for='author'>Author:</label>
      <input type='text' id="author">
    </div>

    <button data-id=' ' class="submitPost">Submit</button>

  </form>
</div>

<div class='posts'>

</div>

<script src="scripts/jquery-min.js"></script>
<script src="scripts/script.js"></script>
</body>
</html>