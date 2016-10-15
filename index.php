<?php
  $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
  include_once($DOC_ROOT."/includes/base.php");
  include_once($DOC_ROOT."/includes/rss.php");
  include_once($DOC_ROOT."/includes/cookies.php");

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
  if(cookies_has_session() != false){
    header("Location: /backend/dashboard.php");
  }else{
    header("Location: /login.php");
  }
?>
