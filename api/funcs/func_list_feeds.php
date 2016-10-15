<?php
  $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
  include_once($DOC_ROOT.'/includes/base.php');
  include_once($DOC_ROOT.'/includes/conf.php');
  include_once($DOC_ROOT.'/includes/auth.php');

  function api_list_feeds($token) {
    global $DEBUG;

    if($_SERVER['REQUEST_METHOD'] !== 'POST')
      return json_encode(array('success' => false, 'reason' => 'Must issue a POST request'));

    if(is_null($token))
      return json_encode(array('success' => false, 'reason' => 'Missing token'));

    if(!auth_validate_token($token))
      return json_encode(array('success' => false, 'reason' => 'Invalid token'));

    $sqlFeeds = 'SELECT title, link, description, href FROM feeds';
    $conn = base_get_connection();
    try{
      $result = $conn->query($sqlFeeds);
      $conn = null;
      $result = $result->fetchAll();

      $returnArray = array('success' => true, 'items' => array());
      foreach($result as $item) {
        $itemArray = array('title' => $item['title'], 'link' => $item['href'], 'description' => $item['description'], 'href' => $item['href']);
        array_push($returnArray['items'], $itemArray);
      }
      return json_encode($returnArray);
    }catch(PDOException $e){
      $conn = null;
      $returnArray = array('success' => false, 'reason' => 'Unknown error');
      if($DEBUG) array_push($returnArray['message'], $e->getMessage());
      return $returnArray;
    }
  }
?>
