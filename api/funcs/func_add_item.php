<?php
  $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
  include_once($DOC_ROOT."/includes/base.php");
  include_once($DOC_ROOT."/includes/conf.php");

  $RFC_REGEX = "(Mon|Tue|Wed|Thu|Fri|Sat|Sun), (\d{2}) (Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) (\d{4}) (\d{2}:\d{2}:\d{2})";
  $MONTHS = array("Jan" => "01", "Feb" => "02", "Mar" => "03", "Apr" => "04", "May" => "05", "Jun" => "06", "Jul" => "07", "Aug" => "08", "Sep" => "09", "Oct" => "10", "Nov" => "11", "Dec" => "12");

  function api_add_item($feed_id, $item_title, $item_link, $item_desc, $item_pubDate, $item_offset, $item_guid, $item_isPermaLink) {
    global $RFC_REGEX, $MONTHS, $DEBUG;
    if(is_null($feed_id)) {
      return json_encode(array("success" => false, "reason" => "No feed ID provided"));
    }

    if(is_null($item_title)){
      return json_encode(array("success" => false, "reason" => "No title provided"));
    }

    if(is_null($item_link)){
      return json_encode(array("success" => false, "reason" => " No link provided"));
    }

    if(is_null($item_desc)){
      return json_encode(array("success" => false, "reason" => "No description provided"));
    }

    if(!is_null($item_pubDate) && preg_match("($RFC_REGEX)", $item_pubDate) != 1){
      return json_encode(array("success" => false, "reason" => "pubDate must comply with RFC 2822 (without offset)"));
    }

    if(!is_null($item_offset) && preg_match("([+-]\d{4})", $item_offset) != 1){
      return json_encode(array("success" => false, "reason" => "Offset must comply with RFC 2822"));
    }

    if(!is_null($item_isPermaLink) && is_null(base_get_boolean($item_isPermaLink))){
      return json_encode(array("success" => false, "reason" => "isPermaLink must be boolean"));
    }

    if(!is_null($item_pubDate)){
      preg_match("($RFC_REGEX)", $item_pubDate, $splitten);
      $parsed_date = $splitten[4]."-".$MONTHS[$splitten[3]]."-".$splitten[2]." ".$splitten[5];
    }else{
      $parsed_date = null;
    }

    $item_isPermaLink = base_get_boolean($item_isPermaLink);

    $sqlCheckFeed = "SELECT id FROM feeds WHERE id = $feed_id";
    $conn = base_get_connection();
    $check = $conn->query($sqlCheckFeed);
    if(!base_fetch_lazy($check)){
      $conn = null;
      return json_encode(array("success" => false, "reason" => "No feed with ID $feed_id"));
    }
    $sqlAdd = "INSERT INTO feed_items (feed, title, link, description, pubDate, offset, guid, isPermaLink) VALUES ($feed_id, '$item_title', '$item_link', '$item_desc', ";
    if(is_null($parsed_date)) $sqlAdd .= "NULL, "; else $sqlAdd .= "'$parsed_date', ";
    if(is_null($item_offset)) $sqlAdd .= "'+0000', "; else $sqlAdd .= "'$item_offset', ";
    if(is_null($item_guid)) $sqlAdd .= "NULL, "; else $sqlAdd .= "'$item_guid', ";
    if(is_null($item_isPermaLink)) $sqlAdd .= "NULL"; else $sqlAdd .= "'$item_isPermaLink'";
    $sqlAdd .= ")";
    try{
      $result = $conn->query($sqlAdd);
      $conn = null;

      return json_encode(array("success" => true));
    }catch(PDOException $e){
      $conn = null;
      $return_array = array('success' => false, 'reason' => 'Unknown error', 'code' => $e->getCode());
      if($DEBUG){
        array_push($return_array['message'], $e->getMessage());
      }
      return json_encode($return_array);
    }
  }
?>
