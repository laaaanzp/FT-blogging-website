<?php
  include "verify_session.php";
  include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <style>
    table, th, td {
      border: 1px solid black;
    }
    td {
      padding: 6px;
    }
  </style>

</head>
<body>
  <?php 
    $fullname = getSessionFullname();
    echo "<h1>Welcome, {$fullname}!</h1>";
  ?>
  <form action="logout.php">
    <input type="submit" value="Logout" />
  </form><br> 

  <form action="create_blog.php" method="POST">
    <h2>Create Blog</h2>
    <label>Title:</label><br>
    <input required type="text" name="title"><br><br>

    <label>Description:</label><br>
    <input required type="text" name="description"><br><br>

    <label>Content:</label><br>
    <textarea required name="content"></textarea><br><br>

    <input type="submit" name="submit" value="Post Blog">
  </form><br>
  <h2>Blog Posts</h2>
  <table>
    <tr>
      <th>Title</th>
      <th>Description</th>
      <th>Posted By</th>
      <!--
       <th>Date Posted</th>
       <th>Date Updated</th>
      -->
    </tr>
    <?php
      $blog_posts = getBlogPosts();
      foreach ($blog_posts as $blog_post) {
        $id = $blog_post["id"];
        $author_id = $blog_post["author_id"];
        $author_name = getUserFullname($author_id);
        $title = $blog_post["title"];
        $description = $blog_post["description"];
        $creation_date = $blog_post["creation_date"];
        $update_date = $blog_post["update_date"];

        echo "<tr>";
        echo "<td><a href='./blog.php?id={$id}'>" . $title . "</a></td>";
        echo "<td>" . $description . "</td>";
        echo "<td>" . $author_name . "</td>";
        // echo "<td>" . $creation_date   . "</td>";
        // echo "<td>" . $update_date . "</td>";
        echo "</tr>";
      }
    ?>
  </table>
</body>
</html>