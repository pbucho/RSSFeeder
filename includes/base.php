<?php
  include_once("conf.php");
  include_once("conf_test.php");

  class Base {
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
  }

  function base_get_connection(){
    global $server, $database, $username, $password;

    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  }

  function base_fetch_lazy($result){
		return $result->fetch(PDO::FETCH_LAZY);
	}

  function base_get_boolean($value){
    if(strcmp($value, "true") === 0)
      return true;
    else if(strcmp($value, "false") === 0)
      return false;
    else if(strcmp($value, "1") === 0)
      return true;
    else if(strcmp($value, "0") === 0)
      return false;
    else
      return null;
  }

  // http://php.net/manual/en/function.json-last-error.php#115980
  function base_utf8ize($d) {
    if (is_array($d)) {
      foreach ($d as $k => $v) {
        $d[$k] = base_utf8ize($v);
      }
    } else if (is_string ($d)) {
      return utf8_encode($d);
    }
    return $d;
  }
?>
