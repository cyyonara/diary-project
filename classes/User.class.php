<?php
include("Db.php");

class User extends Db
{
  private $username;
  private $password;
  public $image = null;

  public function __construct($username, $password, $image = null)
  {
    $this->username = $username;
    $this->password = $password;
    $this->image = $image;
  }

  public static function is_user_exist($info)
  {
    try {
      $pdo = parent::connect();
      if (is_int($info)) {
        $id = $info;
        $query = "SELECT * FROM users WHERE id = :id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
      } elseif (is_string($info)) {
        $username = $info;
        $query = "SELECT * FROM users WHERE username = :username;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username",  $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
      }
    } catch (PDOException $e) {
      die("Database Error: " . $e->getMessage());
    }
  }

  public function login()
  {
    try {
      session_start();
      $pdo = parent::connect();
      $query = "SELECT * FROM users WHERE username = :username";
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(":username", $this->username);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        if (password_verify($this->password, $user["password"])) {
          $_SESSION["auth_id"] = $user["id"];
          header("Location: ../views/home.php");
        } else {
          $_SESSION["login_invalid"] = "Invalid username or password";
          header("Location: ../index.php");
        }
      } else {
        $_SESSION["login_invalid"] = "Invalid username or password";
        header("Location: ../index.php");
      }
    } catch (PDOException $e) {
      die("Database Error: " . $e->getMessage());
    }
  }

  public function signup()
  {
    session_start();
    $fileName = $this->image["name"];
    $fileError = $this->image["error"];
    $fileSize = $this->image["size"];
    $fileExt = explode(".", $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed_file = ["jpg", "png", "jpeg"];

    if (empty($this->username) || empty($this->password)) {
      $_SESSION["signup_invalid"] = "Please fillout all fields";
      $_SESSION["signup_form"] = [
        "username" => $this->username,
        "password" => $this->password,
      ];
      header("Location: ../views/signup.php");
    } elseif (empty($this->image["name"])) {
      $_SESSION["signup_invalid"] = "Please select an image to upload";
      $_SESSION["signup_form"] = [
        "username" => $this->username,
        "password" => $this->password,
      ];
      header("Location: ../views/signup.php");
    } elseif (!in_array($fileActualExt, $allowed_file)) {
      $_SESSION["signup_invalid"] = "Only image files are allowed";
      $_SESSION["signup_form"] = [
        "username" => $this->username,
        "password" => $this->password,
      ];
      header("Location: ../views/signup.php");
    } elseif ($fileError !== 0) {
      $_SESSION["signup_invalid"] = "Error uploading image";
      $_SESSION["signup_form"] = [
        "username" => $this->username,
        "password" => $this->password,
      ];
      header("Location: ../views/signup.php");
    } elseif (self::is_user_exist($this->username)) {
      $_SESSION["signup_invalid"] = "Username already exist";
      $_SESSION["signup_form"] = [
        "username" => "",
        "password" => $this->password,
      ];
      header("Location: ../views/signup.php");
    } else {
      try {
        session_start();
        $fileNewName = time() . "." . $fileActualExt;
        $fileDestination = "../uploads/" . $fileNewName;
        move_uploaded_file($this->image["tmp_name"], $fileDestination);
        $pdo = parent::connect();
        $option = ["cost" => 12];
        $hashpwd = password_hash($this->password, PASSWORD_BCRYPT, $option);
        $query = "INSERT INTO users(username, password, image)
                  VALUES(:username, :password, :image);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $hashpwd);
        $stmt->bindParam(":image", $fileNewName);
        $stmt->execute();
        $_SESSION["signup_success"] = true;
        header("Location: ../views/signup.php");
      } catch (PDOException $e) {
        die("Database Error: " > $e->getMessage());
      }
    }
  }
}
