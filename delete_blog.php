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
    echo "<h4>Invalid blog.</h4>"; 
    exit;
  }

  $author_id = $blog["author_id"];
  $user_id = $_SESSION["user_id"];

  if ($author_id != $user_id) {
    echo "<h4>You don't own this blog to delete it.</h4>"; 
    exit;
  }

  $sql = "DELETE FROM blog_posts WHERE id = {$blog_id}";
  mysqli_query($db_conn, $sql);
  header("Location: dashboard.php");
?>