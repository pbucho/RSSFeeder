<?php
  include_once("funcs/func_get_user.php");
  if($_SERVER['REQUEST_METHOD'] !== 'POST')
    return json_encode(array('success' => false, 'reason' => 'Must issue a POST request'));
  echo api_get_user(isset($_POST['token']) ? $_POST['token'] : null);
?>
