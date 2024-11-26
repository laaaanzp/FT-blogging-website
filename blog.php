<?php 
  include "verify_session.php";
  include "db.php";

  if (empty($_GET["id"])) {
    echo "<h4>Error: Missing id</h4>";
    exit;
  }

  $blog_id = $_GET["id"];
  $blog = getBlogPost($blog_id);

  if (empty($blog)) {
    echo "<h4>Error: Invalid blog</h4>";
    exit;
  }
?>
  <a href="./dashboard.php">Back to dashboard</a>
<?php
  $author_id = $blog["author_id"];
  $author_name = getUserFullname($author_id);

  $title = $blog["title"];
  $description = $blog["description"];
  $content = $blog["content"];
  $creation_date = $blog["creation_date"];
  $update_date = $blog["update_date"];
  
  echo "<h2>Title: {$title}</h2>";
  echo "<p>Description: {$description}<br>";
  echo "Author: {$author_name}<br>";
  echo "<i>posted on {$creation_date}, last updated on {$update_date}</i></p>";
  echo "<p>Content:<br>{$content}</p>";

  if ($author_id == $_SESSION["user_id"]) {
    echo "
      <form action='./edit_blog.php' action='GET'>
        <input hidden type='number' name='id' value=${blog_id}>
        <input type='submit' value='Edit Blog'>
      </form>

      <form action='./delete_blog.php' action='GET'>
        <input hidden type='number' name='id' value=${blog_id}>
        <input type='submit' value='Delete Blog'>
      </form>";
  }
?>