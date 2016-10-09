<?php
  include_once("conf.php");

  function base_get_connection(){
    global $server, $database, $username, $password;

    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  }

  function base_fetch_lazy($result){
		return $result->fetch(PDO::FETCH_LAZY);
	}
?>
