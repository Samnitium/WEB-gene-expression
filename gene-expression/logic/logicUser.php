<?php

	
	include('../model/user.php');
	include_once('logic.php');
	
	class LogicUser extends Logic {

		var $user;
	
		function __construct() {
			parent::__construct();
			$this->user = null;	
		}
		
		
		public function __get($value) {
			return $this->$value;
		}
	
		public function __set($name,$value) {
			$this->$name = $value;
		}	
	
		function insertUser() {
			$this->user = $this->DTO->getValue('user');
			$list = $this->createList();
			$this->db->insert('user',$list);
		}
		
		function deleteUserById() {
			$this->user = $this->DTO->getValue('user');
			$this->db = openDb();
			$this->db->delete('user','id='.$this->user->id);
		}
		
		function retrieveUserById($iduser) {
			$this->db->execute("SELECT * FROM user WHERE id='".$iduser."'");
			$result = $this->db->fetchrow();
			if ($result) {
				if (count($result)!=0) {
				$user = new User();
				$user->id = $iduser;
				$user->email = $result['email'];
				$user->password = $result['password'];
				$user->name = $result['name'];
				$user->surname = $result['surname']; 
				$user->type = $result['type'];
				return $user;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		
		function retrieveUserByEmail($email) {
			$this->db->execute("SELECT * FROM user WHERE email='".$email."'");
			$result = $this->db->fetchrow();
			if ($result) {
				if (count($result)!=0) {
				$user = new User();
				$user->id = $result['id'];
				$user->email = $result['email'];
				$user->password = $result['password'];
				$user->name = $result['name'];
				$user->surname = $result['surname']; 
				$user->type = $result['type'];
				return $user;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function createList() {
			$list = array();
			$list['id'] = $this->user->id;
			$list['email'] = $this->user->email;
			$list['password'] = $this->user->password;
			$list['name'] = $this->user->name;
			$list['surname'] = $this->user->surname;
			$list['type'] = $this->user->type;
			return $list;
			
		}
		
	}



?>