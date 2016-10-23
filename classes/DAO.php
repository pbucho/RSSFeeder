<?php
  require_once("../includes/conf.php");
  require_once("../includes/conf_test.php");
  require_once("User.php");
  require_once("Feed.php");

  class DAO {
    public function getConnection(){
      global $server, $database, $username, $password;
      global $serverTest, $databaseTest, $usernameTest, $passwordTest, $DEBUG;
      if($DEBUG){
        $server = $serverTest;
        $database = $databaseTest;
        $username = $usernameTest;
        $password = $passwordTest;
      }

      $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    }

    public function getUserById($userId) {
      if(!is_int($userId)){
        throw new InvalidArgumentException("User ID must be an integer");
      }
      $sqlUser = "SELECT id, name, password, registered, last_login, last_ip FROM users WHERE id = $userId";
      $conn = $this->getConnection();
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

    public function getFeedById($id) {
      if(!is_int($id)){
        throw new InvalidArgumentException("Feed ID must be an integer");
      }
      $sqlFeed = "SELECT id, title, link, description, href FROM feeds WHERE id = $id";
      $conn = $this->getConnection();
      $storedFeed = $conn->query($sqlFeed);
      $conn = null;

      $storedFeed = $storedFeed->fetch();
      if($storedFeed === false){
        return null;
      }

      $feed = new Feed();
      $feed->setId($storedFeed['id']);
      $feed->setTitle($storedFeed['title']);
      $feed->setLink($storedFeed['link']);
      $feed->setDescription($storedFeed['description']);
      $feed->setHref($storedFeed['href']);

      return $feed;
    }
  }
?>
