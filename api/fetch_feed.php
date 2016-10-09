<?php
  include_once("funcs/func_fetch_feed.php");
  echo api_fetch_feed(isset($_GET['id']) ? $_GET['id'] : null);
?>
