<?php
	include_once("base.php");
	include_once("cookies.php");

	class Auth {

		/**
		*	Receives a username and a password and checks if they form a valid login
		*/
		public function validateLogin($user, $pswd) {
			$sqlValidate = "SELECT password FROM users WHERE name ='$user'";
			$conn = (new Base())->getConnection();
			try{
				$result = $conn->query($sqlValidate);
				$conn = null;
				$result = base_fetch_lazy($result)['password'];

				return password_verify($pswd, $result);
			}catch(PDOException $e){
				$conn = null;
				return false;
			}
		}

		/**
		*	Verifies if there is a valid login from the user-provided cookies. Returns
		* the corresponding token if there is a valid login, and returns null if
		*	tere's not.
		*/
		public function verifyLogin() {
			$token = cookies_has_session();
			if(!is_null($token)){
				return $this->validateToken($token) === false ? null : $token;
			}
			else return null;
		}

		public function validateToken($token) {
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

	function auth_invalidate_token($token) {
		$sqlInvalidate = "DELETE FROM authentication WHERE token = '$token'";
		$conn = base_get_connection();
		try{
			$conn->query($sqlInvalidate);
			$conn = null;
			return true;
		}catch(PDOException $e){
			$conn = null;
			return false;
		}
	}
?>
