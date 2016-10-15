<?php
  include_once("funcs/func_list_feeds.php");
  echo api_list_feeds(isset($_POST['token']) ? $_POST['token'] : null);
?>
