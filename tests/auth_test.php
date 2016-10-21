<?php
  require("../includes/base.php");
  require("../includes/auth.php");

  class AuthTest extends PHPUnit_Framework_TestCase {
    protected $base;

    protected function setUp() {
      $this->base = new Base();
      $sqlDel = "DELETE FROM users WHERE name = 'testUser'";
      $conn = $this->base->getConnection();
      $conn->query($sqlDel);
      $conn = null;
    }

    public function testPasswordValidation1() {
      $sqlIns = "INSERT INTO users (id, name, password, registered, last_login, last_ip) VALUES (1, 'testUser', '\$2y\$10\$5rOG.sLJ28/4X4gu5J7wBedKLqy77NG5OVt6n8iRH1Q2tZwDqzjim', NOW(), NULL, NULL)";
      $conn = $this->base->getConnection();
      $conn->query($sqlIns);
      $conn = null;

      $auth = new Auth();
      $this->assertTrue($auth->validateLogin("testUser","testPassword"));
    }

    public function testPasswordValidation2() {
      $auth = new Auth();
      $this->assertFalse($auth->validateLogin("testUser","testPassword"));
    }
  }
?>
