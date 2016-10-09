<?php
  $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
  include_once($DOC_ROOT."/includes/base.php");

  function api_add_item($feed_id, $item_title, $item_link, $item_desc, $item_pubDate, $item_guid) {
    if(is_null($feed_id)) {
      return json_encode(array("success" => false, "reason" => "No feed ID provided"));
    }

    if(is_null($item_title)){
      return json_encode(array("success" => false, "reason" => "No title provided"));
    }

    if(is_null($item_link)){
      return json_encode(array("succes" => false, "reason" => " No link provided"));
    }

    if(is_null($item_desc)){
      return json_encode(array("success" => false, "reason" => "No description provided"));
    }

    $sqlCheckFeed = "SELECT id FROM feeds WHERE id = $feed_id";
    $conn = base_get_connection();
    $check = $conn->query($sqlCheckFeed);
    if(!base_fetch_lazy($check)){
      $conn = null;
      return json_encode(array("success" => false, "reason" => "No feed with ID $feed_id"));
    }
    $sqlAdd = "INSERT INTO feed_items (feed, title, link, description, pubDate, guid) VALUES ($feed_id, '$item_title', '$item_link', '$item_desc', ";
    if(is_null($item_pubDate)) $sqlAdd .= "NULL, "; else $sqlAdd .= " '$item_pubDate', ";
    if(is_null($item_guid)) $sqlAdd .= " NULL"; else $sqlAdd .= " '$item_guid'";
    $sqlAdd .= ")";
    try{
      $result = $conn->query($sqlAdd);
      $conn = null;

      return json_encode(array("success" => true));
    }catch(PDOException $e){
      $conn = null;
      return json_encode(array('success' => false, 'reason' => 'Unknown error', 'code' => $e->getCode()));
    }
  }
?>
