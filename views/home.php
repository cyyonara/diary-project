<?php
session_start();
if (!isset($_SESSION["auth_id"])) {
  header("Location: ../index.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/global.css" />
  <title>Home</title>
</head>

<body>

</body>

</html>