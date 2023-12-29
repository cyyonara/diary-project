<?php
include("../classes/User.class.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $image = $_FILES["image"];
  $user = new User($username, $password, $image);
  $user->signup();
} else {
  header("Location: ../views/signup.php");
  die();
}
