<?php
  require_once("GlobalTestConfig.php");
  require_once("../includes/base.php");
  require_once("../includes/auth.php");

  class AuthVerifyLoginTest extends GlobalTestConfig {

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
