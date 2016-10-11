<?php
	$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
	include_once("base.php");

	function auth_validate_token($token) {
		$sqlValidate = "SELECT token, expiry FROM authentication WHERE token = '$token'";
		$conn = base_get_connection();
		$result = $conn->query($sqlValidate);
		$conn = null;

		$result = base_fetch_lazy($result);
		if($result == false){
			return false;
		}

		if(is_null($result['expiry']))
			return true;

		$expiry = new DateTime($result['expiry'], new DateTimeZone("UTC"));
		$expiry = $expiry->getTimestamp();
		$now = time();

		if($now > $expiry)
			return true;
		else
			return false;
	}

	function auth_generate_token() {
		return bin2hex(openssl_random_pseudo_bytes(16));
	}

	function auth_generate_and_persist_token($expiry) {
		$generated_token = auth_generate_token();
		$sqlToken = "INSERT INTO authentication (token, owner, created, expiry) VALUES ('$generated_token', NULL, NOW(), ";
		if(is_null($expiry)) $sqlToken .= "NULL"; else $sqlToken .= "'$expiry'";
		$sqlToken .= ")";
		$conn = base_get_connection();
		try{
			$conn->query($sqlToken);
			$conn = null;
			return $generated_token;
		}catch(PDOException $e){
			$conn = null;
			return null;
		}
	}
?>
