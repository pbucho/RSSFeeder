<?php
  require("../includes/base.php");
  require("../includes/auth.php");

  class AuthVerifyLoginTest extends PHPUnit_Framework_TestCase {
    protected $base;

    protected function setUp() {
      $this->base = new Base();
      $sqlDelTok = "DELETE FROM authentication";
      $sqlDelUsr = "DELETE FROM users";
      $conn = $this->base->getConnection();
      $conn->query($sqlDelTok);
      $conn->query($sqlDelUsr);
      $conn = null;
    }

    private function addUser() {
      $sqlInsUsr = "INSERT INTO users (id, name, password, registered, last_login, last_ip) VALUES (1, 'testUser', '\$2y\$10\$5rOG.sLJ28/4X4gu5J7wBedKLqy77NG5OVt6n8iRH1Q2tZwDqzjim', NOW(), NULL, NULL)";
      $conn = $this->base->getConnection();
      $conn->query($sqlInsUsr);
      $conn = null;
    }

    private function addToken() {
      $sqlInsTok = "INSERT INTO authentication (token, owner, created, expiry) VALUES ('abcd', 1, NOW(), NULL)";
      $conn = $this->base->getConnection();
      $conn->query($sqlInsTok);
      $conn = null;
    }

    public function testVerifyLogin() {
      $this->addUser();
      $this->addToken();

      $_COOKIE['token'] = 'abcd';

      $auth = new Auth();
      $this->assertEquals('abcd', $auth->verifyLogin());
    }

    public function testVerifyLoginNoCookie() {
      $this->addUser();
      $this->addToken();

      $_COOKIE['token'] = null;

      $auth = new Auth();
      $this->assertNull($auth->verifyLogin());
    }

    public function testVerifyLoginInvalidToken() {
      $this->addUser();

      $_COOKIE['token'] = 'abcd';

      $auth = new Auth();
      $this->assertNull($auth->verifyLogin());
    }

    public function testVerifyLoginInvalidToken2() {
      $this->addUser();
      $this->addToken();

      $_COOKIE['token'] = 'xyz';

      $auth = new Auth();
      $this->assertNull($auth->verifyLogin());
    }
  }
?>
