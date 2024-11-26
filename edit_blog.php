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
?>
  <a href="./dashboard.php">Back to dashboard</a><br><br>
  <h2>Edit Blog</h2>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $author_id = $blog["author_id"];
    $author_name = getUserFullname($author_id);

    $user_id = $_SESSION["user_id"];
    if ($author_id != $user_id) {
      echo "<h4>You don't own this blog to perform an edit."; 
      exit;
    }

    $title = $blog["title"];
    $description = $blog["description"];
    $content = $blog["content"];
    $creation_date = $blog["creation_date"];
    $update_date = $blog["update_date"];

    echo 
      "<form action='{$_SERVER['REQUEST_URI']}' method='POST'> 
        <input hidden type='number' value={$blog_id}>
        <label>Title:</label><br>
        <input required type='text' name='title' value='{$title}'><br><br>

        <label>Description:</label><br>
        <input required type='text' name='description' value='{$description}'><br><br>

        <label>Content:</label><br>
        <textarea required name='content'>{$content}</textarea><br><br>

        <input type='submit' name='submit' value='Update Blog'>
      </form>";
  } else {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $content = $_POST["content"];

    $sql = "UPDATE blog_posts 
            SET
              title = ?,
              description = ?,
              content = ?,
              update_date = NOW()
            WHERE
              id = ?
            ";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $description, $content, $blog_id);
    $stmt->execute();

    header("Location: dashboard.php");
  }
?>