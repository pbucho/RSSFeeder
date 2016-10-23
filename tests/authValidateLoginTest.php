<?php
  require_once("GlobalTestConfig.php");
  require_once("../includes/base.php");
  require_once("../includes/auth.php");

  class AuthValidateLoginTest extends GlobalTestConfig {

    public static function setupBeforeClass() {
      $sqlTruncTokens = "TRUNCATE TABLE authentication";
      $conn = (new Base())->getConnection();
      $conn->query($sqlTruncTokens);
      $conn = null;
    }

    public function testPasswordValidation() {
      $sqlIns = "INSERT INTO users (id, name, password, registered, last_login, last_ip) VALUES (1, 'testUser', '\$2y\$10\$5rOG.sLJ28/4X4gu5J7wBedKLqy77NG5OVt6n8iRH1Q2tZwDqzjim', NOW(), NULL, NULL)";
      $conn = (new Base())->getConnection();
      $conn->query($sqlIns);
      $conn = null;

      $auth = new Auth();
      $this->assertTrue($auth->validateLogin("testUser","testPassword"));
    }

    public function testPasswordNoUser() {
      $auth = new Auth();
      $this->assertFalse($auth->validateLogin("testUser","testPassword"));
    }

    public function testPasswordWrongPassword() {
      $sqlIns = "INSERT INTO users (id, name, password, registered, last_login, last_ip) VALUES (1, 'testUser', '\$2y\$10\$5rOG.sLJ28/4X4gu5J7wBedKLqy77NG5OVt6n8iRH1Q2tZwDqzjim', NOW(), NULL, NULL)";
      $conn = (new Base())->getConnection();
      $conn->query($sqlIns);
      $conn = null;

      $auth = new Auth();
      $this->assertFalse($auth->validateLogin("testUser","wrongPassword"));
    }
  }
?>
