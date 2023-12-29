<?php session_start();
if (isset($_SESSION["auth_id"])) {
  header("Location: home.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../styles/global.css" />
  <link rel="stylesheet" href="../styles/index.css" />
  <title>Diary ng Bayot - Signup</title>
</head>

<body>
  <?php
  $signup_form = isset($_SESSION["signup_form"]) ?
    $_SESSION["signup_form"] : ["username" => "", "password" => ""];

  if (isset($_SESSION["signup_invalid"])) {
    $error_message = $_SESSION["signup_invalid"];

    echo "<div class='signup-error'>
            <p>$error_message</p>
            <i class='fa-solid fa-exclamation'></i>    
          </div>";
  }

  if (isset($_SESSION["signup_success"])) {
    echo "<div class='success'>Signed up successfully!</div>";
  }
  ?>
  <main>
    <div class="form-container">
      <div class="logo-container">
        <h1>Create an account</h1>
      </div>
      <form action="../includes/signup.inc.php" method="post" enctype="multipart/form-data">
        <div class="input-container">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="username" placeholder="Username" value="<?php echo $signup_form["username"]; ?>">
        </div>
        <div class="input-container">
          <i class="fa-solid fa-lock"></i>
          <input type="password" name="password" placeholder="Password" value="<?php echo $signup_form["password"]; ?>">
        </div>
        <div class="image-container">
          <button type="button" class="select">Select Image</button>
          <input hidden accept="image/*" type="file" name="image">
          <div class="file-container"></div>
        </div>
        <button type="submit" name="signup" value="signup">
          Sign up
        </button>
        <p>Already have an account? <a href="../index.php">Login</a></p>
      </form>
    </div>
  </main>
</body>
<script src="../scripts/signup.js"></script>
<?php
unset($_SESSION["signup_invalid"]);
unset($_SESSION["signup_form"]);
unset($_SESSION["signup_success"]);
?>

</html>