<?php
  include_once("funcs/func_list_feeds.php");
  if($_SERVER['REQUEST_METHOD'] !== 'POST')
    return json_encode(array('success' => false, 'reason' => 'Must issue a POST request'));
  echo api_list_feeds(isset($_POST['token']) ? $_POST['token'] : null);
?>