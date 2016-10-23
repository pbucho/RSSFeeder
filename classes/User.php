<?php

  class User {
    private $id;
    private $name;
    private $password;
    private $registered;
    private $lastLogin;
    private $lastIp;

    public function getId() {
      return $this->id;
    }

    public function getName() {
      return $this->name;
    }

    public function getPassword() {
      return $this->password;
    }

    public function getRegistered() {
      return $this->registered;
    }

    public function getLastLogin() {
      return $this->lastLogin;
    }

    public function getLastIp() {
      return $this->lastIp;
    }

    //////////////////////////////

    public function setId($id) {
      $this->id = $id;
    }
    
    public function setName($name) {
      $this->name = $name;
    }

    public function setPassword($password) {
      $this->password = $password;
    }

    public function setRegistered($registered) {
      $this->registered = $registered;
    }

    public function setLastLogin($lastLogin) {
      $this->lastLogin = $lastLogin;
    }

    public function setLastIp($lastIp) {
      $this->lastIp = $lastIp;
    }
  }

?>
