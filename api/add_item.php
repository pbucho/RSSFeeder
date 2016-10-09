<?php
  include_once("funcs/func_add_item.php");
  echo api_add_item(isset($_GET['id']) ? $_GET['id'] : null,
                    isset($_GET['title']) ? $_GET['title'] : null,
                    isset($_GET['link']) ? $_GET['link'] : null,
                    isset($_GET['desc']) ? $_GET['desc'] : null,
                    isset($_GET['pubDate']) ? $_GET['pubDate'] : null,
                    isset($_GET['guid']) ? $_GET['guid'] : null);
?>
