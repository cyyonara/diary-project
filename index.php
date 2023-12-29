<?php
session_start();
if (isset($_SESSION["auth_id"])) {
  header("Location: ./views/home.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./styles/global.css" />
  <link rel="stylesheet" href="./styles/index.css" />
  <title>Diary ng Bayot - Login</title>
</head>

<body>
  <?php
  if (isset($_SESSION["login_invalid"])) {
    $error_message = $_SESSION["login_invalid"];

    echo "<div class='login-error'> 
            <p>$error_message</p>
            <i class='fa-solid fa-exclamation'></i>    
          </div>";
  }
  ?>
  <main>
    <div class="form-container">
      <div class="logo-container">
        <i class="fa-solid fa-book"></i>
        <h1>Diary ng Bayot</h1>
      </div>
      <form action="./includes/login.inc.php" method="post">
        <div class="input-container">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="username" placeholder="Username">
        </div>
        <div class="input-container">
          <i class="fa-solid fa-lock"></i>
          <input type="password" name="password" placeholder="Password">
        </div>
        <button type="submit" name="login" value="login">
          Login
        </button>
        <p>Don't have an account? <a href="./views/signup.php">Sign up</a></p>
      </form>
    </div>
  </main>
</body>
<?php unset($_SESSION["login_invalid"]); ?>

</html>