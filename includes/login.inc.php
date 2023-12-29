<?php
include("../classes/User.class.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
  $username =  trim($_POST["username"]);
  $password = trim($_POST["password"]);
  $user = new User($username, $password);
  $user->login();
} else {
  header("Location: ../index.php");
  die();
}
