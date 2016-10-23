<?php
  require_once("GlobalTestConfig.php");
  require_once("../includes/base.php");
  require_once("../classes/DAO.php");
  require_once("../classes/User.php");
  require_once("../classes/Feed.php");

  class DAOTest extends GlobalTestConfig {

    public function testDaoUser() {
      $sqlUser = "INSERT INTO users (id, name, password, registered, last_login, last_ip) VALUES (250, 'testUser', 'testPassword', '20161023161113', NULL, NULL)";
      $conn = (new DAO())->getConnection();
      $conn->query($sqlUser);
      $conn = null;

      $user = (new DAO())->getUserById(250);

      $this->assertEquals(250, $user->getId());
      $this->assertEquals("testUser", $user->getName());
      $this->assertEquals("testPassword", $user->getPassword());
      $this->assertEquals(new DateTime("2016-10-23 16:11:13"), $user->getRegistered());
      $this->assertNull($user->getLastLogin());
      $this->assertNull($user->getLastIp());
    }

    public function testDaoFeed() {
      $sqlFeed = "INSERT INTO feeds (id, title, link, description, href) VALUES (20, 'feedTitle', 'http://example.com', 'feedDescription', NULL)";
      $conn = (new DAO())->getConnection();
      $conn->query($sqlFeed);
      $conn = null;

      $feed = (new DAO())->getFeedById(20);

      $this->assertEquals(20, $feed->getId());
      $this->assertEquals("feedTitle", $feed->getTitle());
      $this->assertEquals("http://example.com", $feed->getLink());
      $this->assertEquals("feedDescription", $feed->getDescription());
      $this->assertNull($feed->getHref());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentUser() {
      (new DAO())->getUserById("abc");
      $this->fail("Should have thrown exception");
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentFeed() {
      (new DAO())->getFeedById("abc");
      $this->fail("Should have thrown exception");
    }
  }
?>
