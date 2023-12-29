<?php
abstract class Db
{
  private static $host = "localhost";
  private static $database = "diary";
  private static $user = "root";
  private static $password = "";

  protected static function connect()
  {
    try {
      $pdo = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$database . ";", self::$user, self::$password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $e) {
      die("Database Error: " . $e->getMessage());
    }
  }
}
