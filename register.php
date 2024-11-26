<?php
  include "db.php";

  if (!empty($_POST["submit"])) {

    $email = $_POST["email"];
    $full_name = trim($_POST["full_name"]);
    $password = $_POST["password"];
    $date_of_birth = $_POST["date_of_birth"];

    if (strlen($password) < 8) {
      echo "<h4>Error: Password is too short.</h4><br>";
    } else {
      $password_hashed = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO accounts(email, password, full_name, date_of_birth) VALUES (?, ?, ?, ?)";
      $stmt = $db_conn->prepare($sql);
      $stmt->bind_param("ssss", $email, $password_hashed, $full_name, $date_of_birth);
      try {
        if ($stmt->execute()) {
          header("Location: login.php");
          exit;
        } else {
          echo "<h4>Error creating account.<h4>";
        }
      } catch (exception) {
        echo "<h4>Email already exists.<h4>";
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>
</head>
<body>
  <form action=<?php echo $_SERVER['REQUEST_URI'] ?> method="POST">
    <h2>Register</h2>

    <label>Email:</label><br>
    <input required type="email" name="email"><br><br>

    <label>Fullname:</label><br>
    <input required type="text" name="full_name"><br><br>

    <label>Password:</label><br>
    <input required type="password" name="password"><br><br>

    <label>Date of Birth:</label><br>
    <input required type="date" name="date_of_birth"><br><br>

    <input type="submit" name="submit" value="Register"><br><br>
    <a href="./login.php">Already have an account? Login here.</a>
  </form>
</body>
</html>