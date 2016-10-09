<?php
  $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
  include_once($DOC_ROOT."/includes/base.php");
  include_once($DOC_ROOT."/includes/rss.php");

  if(isset($_GET['id'])){
    $feed_id = $_GET['id'];
    $sqlCheckFeed = "SELECT id FROM feeds WHERE id = $feed_id";
    $conn = base_get_connection();
    $check = $conn->query($sqlCheckFeed);
    $conn = null;
    if(base_fetch_lazy($check)){
      rss_render_feed($feed_id);
      die;
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>RSS Feeder</title>
    <link rel="stylesheet" href="css/style-login.css">
  </head>
  <body>
    <div class="login-page">
      <div class="form">
        <form class="login-form">
          <input type="text" placeholder="username"/>
          <input type="password" placeholder="password"/>
          <button>login</button>
        </form>
      </div>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js/index.js"></script>
  </body>
</html>
