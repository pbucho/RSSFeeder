<?php
  $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
  include_once("base.php");
  include_once($DOC_ROOT."/api/funcs/func_fetch_feed.php");

  $TAB1 = "  ";
  $TAB2 = "$TAB1  ";
  $TAB3 = "$TAB2  ";
  $NL = "\n";

  function rss_render_feed($feed_id) {
    global $TAB1, $TAB2, $TAB3, $NL;

    $sqlCheckFeed = "SELECT id FROM feeds WHERE id = $feed_id";
    $conn = base_get_connection();
    $check = $conn->query($sqlCheckFeed);
    if(!base_fetch_lazy($check)){
      $conn = null;
      echo "Invalid feed";
      die;
    }
    $feed_contents = json_decode(api_fetch_feed($feed_id), true);

    echo "<?xml version=\"1.0\"?>$NL";
    echo "<rss version=\"2.0\">$NL";
    echo "$TAB1<channel>$NL";
    echo "$TAB2<title>".$feed_contents['title']."</title>$NL";
    echo "$TAB2<link>".$feed_contents['link']."</link>$NL";
    echo "$TAB2<description>".$feed_contents['description']."</description>$NL";
    foreach($feed_contents['items'] as $item){
      echo "$TAB2<item>$NL";
      echo "$TAB3<title>".$item['title']."</title>$NL";
      echo "$TAB3<link>".$item['link']."</link>$NL";
      echo "$TAB3<description>".$item['description']."</description>$NL";
      if(!is_null($item['pubDate'])) echo "$TAB3<pubDate>".$item['pubDate']."</pubDate>$NL";
      if(!is_null($item['guid'])) echo "$TAB3<guid>".$item['guid']."</guid>$NL";
      echo "$TAB2</item>$NL";
    }
    echo "$TAB1</channel>$NL";
    echo "</rss>$NL";
  }
?>
