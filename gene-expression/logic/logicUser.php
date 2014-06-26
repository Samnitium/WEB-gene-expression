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
	
		function insertUser($code) {
			$this->user = $this->DTO->getValue('user');
			$list = $this->createList($code);
			$this->db->insert('user',$list);
		}
		
		function deleteUserById() {
			$this->user = $this->DTO->getValue('user');
			$this->db->delete('user','id='.$this->user->id);
		}
		
		function  retrieveUserByIdAndCode($iduser,$code) {
			$this->db->execute("SELECT * FROM user WHERE id='".$iduser."' and code='".$code."'");
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
		
		function updateAccount($iduser) {
			$this->db->execute("UPDATE user SET account_activated='Y' WHERE id='".$iduser."'");
			
		}
		
		
		function retrieveAllUsers($type) {
			$this->db->execute("SELECT * FROM user WHERE type='".$type."'");
			$result = $this->db->fetchrowset();
			return $result;
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
		
		function updateUser() {
			$this->user = $this->DTO->getValue('user');
			$this->db->execute("UPDATE user SET password='".$this->user->password."', name='".$this->user->name."', surname='".$this->user->surname."' WHERE id='".$this->user->id."'");
					
		}
		
		function retrieveAccountById($iduser) {
			$this->db->execute("SELECT * FROM user WHERE id='".$iduser."'");
			$result = $this->db->fetchrow();
			return $result['account_activated'];
			
		}
		
		function updateCodeUser($code,$iduser) {
			$this->db->execute("UPDATE user SET code='".$code."' WHERE id='".$iduser."'");
		}
		
		
		function createList($code) {
			$list = array();
			$list['id'] = $this->user->id;
			$list['email'] = $this->user->email;
			$list['password'] = $this->user->password;
			$list['name'] = $this->user->name;
			$list['surname'] = $this->user->surname;
			$list['type'] = $this->user->type;
			$list['code'] = $code;
			$list['account_activated'] = "N";
			return $list;
			
		}
		
	}



?>