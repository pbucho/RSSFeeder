<?php
  require_once("../includes/base.php");
  require_once("User.php");

  class DAO {

    public function getUserById($userId) {
      if(!is_int($userId)){
        throw new Exception("User ID must be an integer");
      }
      $sqlUser = "SELECT id, name, password, registered, last_login, last_ip FROM users WHERE id = $userId";
      $base = new Base();
      $conn = $base->getConnection();
      $storedUser = $conn->query($sqlUser);
      $conn = null;

      $storedUser = $storedUser->fetch();
      if($storedUser === false){
        return null;
      }

      $user = new User();
      $user->setId($storedUser['id']);
      $user->setName($storedUser['name']);
      $user->setPassword($storedUser['password']);
      $user->setRegistered(is_null($storedUser['registered']) ? null : new DateTime($storedUser['registered']));
      $user->setLastLogin(is_null($storedUser['last_login']) ? null : new DateTime($storedUser['last_login']));
      $user->setLastIp($storedUser['last_ip']);

      return $user;
    }
  }
?>
