<?php
  $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];

  include_once($DOC_ROOT."/includes/base.php");
  include_once($DOC_ROOT."/includes/conf.php");

  function api_fetch_feed($feed_id) {
    global $ITEM_LIMIT;
    if(is_null($feed_id)) {
      return json_encode(array("success" => false, "reason" => "No feed ID provided"));
    }

    $sqlCheckFeed = "SELECT id FROM feeds WHERE id = $feed_id";
    $conn = base_get_connection();
    $check = $conn->query($sqlCheckFeed);
    if(!base_fetch_lazy($check)){
      $conn = null;
      return json_encode(array("success" => false, "reason" => "No feed with ID $feed_id"));
    }
    $sqlFeed = "SELECT i.title as title, i.link as link, i.description as description, date_format(pubDate, '%a, %d %b %Y %H:%i:%s') as pubDate, pubDate as dateOrder, guid FROM feed_items i LEFT JOIN feeds f ON i.feed = f.id WHERE f.id = $feed_id ORDER BY dateOrder DESC";
    if(isset($ITEM_LIMIT) && $ITEM_LIMIT > 0){
      $sqlFeed .= " LIMIT $ITEM_LIMIT";
    }
    $items = $conn->query($sqlFeed);
    $sqlFeedInfo = "SELECT title, link, description FROM feeds WHERE id = $feed_id";
    $feed_info = $conn->query($sqlFeedInfo);
    $conn = null;
    $feed_info = base_fetch_lazy($feed_info);

    $return_array = array("success" => true, "title" => $feed_info['title'], "link" => $feed_info['link'], "description" => $feed_info['description'], "items" => array());
    foreach($items as $item){
      $item_array = array("title" => $item['title'], "link" => $item['link'], "description" => $item['description'], "pubDate" => $item['pubDate'], "guid" => $item['guid']);
      array_push($return_array["items"], $item_array);
    }
    return json_encode($return_array);
  }
?>
