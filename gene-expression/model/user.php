<?php
	class User {
	
		var $id;
		var $email;
		var $password;
		var $name;
		var $surname;
		var $type;
		
		
		public function __construct() {
			$this->id = null;
			$this->email = null;
			$this->password = null;
			$this->name = null;
			$this->surname = null;
			$this->type = null;
		}
	
	public function __get($value) {
		return $this->$value;
	}
	
	public function __set($name,$value) {
		$this->$name = $value;
	}
	
	
		
}
	
	
	

?>