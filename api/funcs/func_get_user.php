<?php
  $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
  include_once($DOC_ROOT.'/includes/base.php');
  include_once($DOC_ROOT.'/includes/conf.php');
  include_once($DOC_ROOT.'/includes/auth.php');

  function api_get_user($token) {
    global $DEBUG;
    
    if(is_null($token))
      return json_encode(array('success' => false, 'reason' => 'Missing token'));

    if(!auth_validate_token($token))
      return json_encode(array('success' => false, 'reason' => 'Invalid token'));

    $sqlFeeds = "SELECT name FROM users u INNER JOIN authentication a ON u.id = a.owner WHERE a.token = '$token'";
    $conn = base_get_connection();
    try{
      $result = $conn->query($sqlFeeds);
      $conn = null;
      $result = base_fetch_lazy($result);

      $name = $result['name'];
      if(is_null($name))
        return json_encode(array('success' => false, 'reason' => 'Unknown user'));
      else
        return json_encode(array('success' => true, 'username' => $name));
    }catch(PDOException $e){
      $conn = null;
      $returnArray = array('success' => false, 'reason' => 'Unknown error');
      if($DEBUG) array_push($returnArray['message'], $e->getMessage());
      return $returnArray;
    }
  }
?>
