<?php
  include "verify_session.php";
  include "db.php";

  if (!empty($_POST["submit"])) {
    $author_id = $_SESSION["user_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $content = $_POST["content"];

    $sql = "INSERT INTO blog_posts(author_id, title, description, content) VALUES (?, ?, ?, ?)";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("isss", $author_id, $title, $description, $content);
    if ($stmt->execute()) {
      header("Location: dashboard.php");
      exit;
    } else {
      echo "<h4>Error creating blog post.<h4>";
    }
  }
?>