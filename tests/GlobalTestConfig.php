<?php
  require_once("../classes/DAO.php");
  
  class GlobalTestConfig extends PHPUnit_Framework_TestCase {

    protected function setUp() {
      $this->base = new DAO();
      $sqlDelTok = "DELETE FROM authentication";
      $sqlDelUsr = "DELETE FROM users";
      $conn = $this->base->getConnection();
      $conn->query($sqlDelTok);
      $conn->query($sqlDelUsr);
      $conn = null;
    }

    protected function addUser() {
      $sqlInsUsr = "INSERT INTO users (id, name, password, registered, last_login, last_ip) VALUES (1, 'testUser', '\$2y\$10\$5rOG.sLJ28/4X4gu5J7wBedKLqy77NG5OVt6n8iRH1Q2tZwDqzjim', NOW(), NULL, NULL)";
      $conn = $this->base->getConnection();
      $conn->query($sqlInsUsr);
      $conn = null;
    }

    protected function addToken() {
      $sqlInsTok = "INSERT INTO authentication (token, owner, created, expiry) VALUES ('abcd', 1, NOW(), NULL)";
      $conn = $this->base->getConnection();
      $conn->query($sqlInsTok);
      $conn = null;
    }
  }
?>
