<?php
  include_once("conf.php");
  include_once("base.php");
  include_once("rss.php");

  function cache_get_cached_feed_string($feed_id) {
    global $FEED_TTL;
    $cached_feed = apcu_fetch("feed-".$feed_id);
    if($cached_feed == false){
      $cached_feed = rss_get_feed_string($feed_id);
      apcu_store("feed-".$feed_id, $cached_feed, $FEED_TTL);
    }
    return $cached_feed;
  }
?>
