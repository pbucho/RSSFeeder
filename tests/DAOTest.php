<?php
  require_once("GlobalTestConfig.php");
  require_once("../includes/base.php");
  require_once("../classes/DAO.php");

  class DAOTest extends GlobalTestConfig {

    public function testDaoUser() {
      $sqlUser = "INSERT INTO users (id, name, password, registered, last_login, last_ip) VALUES (250, 'testUser', 'testPassword', '20161023161113', NULL, NULL)";
      $conn = (new Base())->getConnection();
      $conn->query($sqlUser);
      $conn = null;

      $dao = new DAO();
      $user = $dao->getUserById(250);

      $this->assertEquals(250, $user->getId());
      $this->assertEquals("testUser", $user->getName());
      $this->assertEquals("testPassword", $user->getPassword());
      $this->assertEquals(new DateTime("2016-10-23 16:11:13"), $user->getRegistered());
      $this->assertNull($user->getLastLogin());
      $this->assertNull($user->getLastIp());
    }

  }
?>
