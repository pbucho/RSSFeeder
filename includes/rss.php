<?php
  $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
  include_once("base.php");
  include_once("cache.php");
  include_once($DOC_ROOT."/api/funcs/func_fetch_feed.php");

  $TAB1 = "  ";
  $TAB2 = "$TAB1  ";
  $TAB3 = "$TAB2  ";
  $NL = "\n";
  $ATOM = "xmlns:atom=\"http://www.w3.org/2005/Atom\"";

  function rss_render_feed($feed_id) {
    header('Content-type: application/rss+xml');
    echo cache_get_cached_feed_string($feed_id);
    die;
  }

  function rss_get_feed_string($feed_id) {
    global $TAB1, $TAB2, $TAB3, $NL, $ATOM;

    $sqlCheckFeed = "SELECT id FROM feeds WHERE id = $feed_id";
    $conn = base_get_connection();
    $check = $conn->query($sqlCheckFeed);
    if(!base_fetch_lazy($check)){
      $conn = null;
      return null;
    }
    $feed_contents = json_decode(api_fetch_feed($feed_id), true);

    $feed_string = "";
    $feed_string .= "<?xml version=\"1.0\"?>$NL";
    $feed_string .= "<rss version=\"2.0\" $ATOM>$NL";
    $feed_string .= "$TAB1<channel>$NL";
    $feed_string .= "$TAB2<title>".$feed_contents['title']."</title>$NL";
    $feed_string .= "$TAB2<link>".$feed_contents['link']."</link>$NL";
    $feed_string .= "$TAB2<description>".$feed_contents['description']."</description>$NL";
    $feed_string .= "$TAB2<atom:link href=\"".(is_null($feed_contents['href']) ? $feed_contents['link'] : $feed_contents['href'])."\" rel=\"self\" type=\"application/rss+xml\" />$NL";
    foreach($feed_contents['items'] as $item){
      $feed_string .= "$TAB2<item>$NL";
      $feed_string .= "$TAB3<title>".$item['title']."</title>$NL";
      $feed_string .= "$TAB3<link>".$item['link']."</link>$NL";
      $feed_string .= "$TAB3<description>".$item['description']."</description>$NL";
      if(!is_null($item['pubDate'])) $feed_string .= "$TAB3<pubDate>".$item['pubDate']." ".$item['offset']."</pubDate>$NL";
      if(!is_null($item['guid'])){
      	$feed_string .= "$TAB3<guid";
      	if(!is_null($item['isPermaLink']) && !$item['isPermaLink']){
      		$feed_string .= " isPermaLink=\"false\"";
      	}
      	$feed_string .= ">".$item['guid']."</guid>$NL";
      }
      $feed_string .= "$TAB2</item>$NL";
    }
    $feed_string .= "$TAB1</channel>$NL";
    $feed_string .= "</rss>$NL";

    return $feed_string;
  }
?>
