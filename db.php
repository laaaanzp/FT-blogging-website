<?php
  $db_host_name = "localhost";
  $db_user_name = "root";
  $db_password = "";
  $db_name = "FT-blogging-website-database";
  $db_conn = null;

  try {
    $db_conn = mysqli_connect($db_host_name,
                              $db_user_name,
                              $db_password,
                              $db_name);
  } catch (mysqli_sql_exception) {
    echo "Error: Database connection error.";
    exit;
  }

  function getSessionFullname(): string {
    global $db_conn;
    $user_id = $_SESSION["user_id"];

    return getUserFullname($user_id);
  }

  function getUserFullname(int $user_id): string {
    global $db_conn;

    $sql = "SELECT * FROM accounts WHERE id = ?";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      return $user["full_name"];
    } else {
      return "N/A";
    }
  }

  function getBlogPost(int $blog_id): array {
    global $db_conn;

    $sql = "SELECT * FROM blog_posts WHERE id = ?";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $result = $stmt->get_result();
    try {
      if ($result->num_rows > 0) {
        return $result->fetch_assoc();
      } else {
        return [];
      }
    } catch (exception) {
      return [];
    }
  }

  function getBlogPosts(): array {
    global $db_conn;

    $sql = "SELECT * FROM blog_posts";
    $result = $db_conn->query($sql);
    try {
      if ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
          $data[] = $row; 
        }
        return $data;
      } else {
        return [];
      }
    } catch (exception) {
      return [];
    }
  }
?>