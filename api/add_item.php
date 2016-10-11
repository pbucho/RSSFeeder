<?php
  include_once("funcs/func_add_item.php");
  echo api_add_item(isset($_POST['token']) ? $_POST['token'] : null,
					isset($_POST['id']) ? $_POST['id'] : null,
					isset($_POST['title']) ? $_POST['title'] : null,
					isset($_POST['link']) ? $_POST['link'] : null,
					isset($_POST['description']) ? $_POST['description'] : null,
					isset($_POST['pubDate']) ? $_POST['pubDate'] : null,
					isset($_POST['offset']) ? $_POST['offset'] : null,
					isset($_POST['guid']) ? $_POST['guid'] : null,
					isset($_POST['isPermaLink']) ? $_POST['isPermaLink'] : null);
?>
