<?php

class User extends DatabaseObject{

	protected static $table_name="User";
	public static $db_fields = array('id', 'username', 'email', 'password', 'join_date');
	public $id;
	public $username;
	public $email;
	public $password;
	public $join_date;
	
	public function authenticate($email = "", $password = ""){
		global $db, $session;
		$email = $db->real_escape_string($email);
		$password = $db->real_escape_string($password);
	
		$sql = "SELECT *
				FROM User
				WHERE email = '{$email}'
				AND password = '{$password}'
				LIMIT 1";
				
		$result = $db->query($sql);
		
		if($result->num_rows > 0){
			$user = new self;
			$record = $result->fetch_array();
			
			$user->id=$record['id'];
			$user->username=$record['username'];
			$user->email=$record['email'];
			$user->password=$record['password'];
		
			$session->login($user);
			return true;
		}
		
		else{
			$session->set_msg("Incorrect Username/Password");
			return false;
		}
	}
	
	public static function user_exists($email){
		return parent::find_all("email", $email);
	}
	
	public function display_name(){
		echo $this->username;
	}
	
	public static function create_user($username, $email, $password){
		global $db;
		$user = new self();
		
		$user->username = $db->real_escape_string($username);
		$user->email = $db->real_escape_string($email);
		$user->password = $db->real_escape_string($password);
		date_default_timezone_set('America/New_York'); 
		$user->join_date = date('Y-m-d H:i:s');
		
		$user->create();
		
		$sql = "SELECT * FROM User WHERE username = '{$user->username}'";
		$result_obj = $db->query($sql);
		
		$result = $result_obj->fetch_array();
		$user->id = $result['id'];
		
		return $user;
		
	}
}

?>