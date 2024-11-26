<?php 
  session_start();
  require_once("db.php");

  if (!empty($_POST["submit"])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM accounts WHERE email = ?";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      if (password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];

        header("Location: dashboard.php");
        exit;
      } else {
        echo "<h4>Wrong password.</h4>";
      }
    } else {
      echo "<h4>User not found!</h4>";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>
<body>
  <form action=<?php echo $_SERVER["REQUEST_URI"] ?> method="POST">
    <h2>Login</h2>

    <label>Email:</label><br>
    <input required type="email" name="email"><br><br>

    <label>Password:</label><br>
    <input required type="password" name="password"><br><br>

    <input type="submit" name="submit" value="Login"><br><br>
    <a href="./register.php">No account yet? Register here.</a>
  </form>
</body>
</html>