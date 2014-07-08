<?php

	
	include('../model/viewPermission.php');
	include_once('logic.php');
	
	class LogicViewPermission extends Logic {

		var $viewPermission;
	
		function __construct() {
			parent::__construct();
			$this->viewPermission = null;	
		}
		
		
		public function __get($value) {
			return $this->$value;
		}
	
		public function __set($name,$value) {
			$this->$name = $value;
		}	
	
		function insertViewPermission() {
			$this->viewPermission = $this->DTO->getValue('viewPermission');
			$list = $this->createList();
			$this->db->insert('viewpermission',$list);
		}
		
		function deleteViewPermissionByIdUser() {
			$this->viewPermission= $this->DTO->getValue('viewPermission');
			$this->db->delete('viewpermission','id_user='.$this->viewPermission->id_user);
		}
		function deleteViewPermissionByIdExperiment($id_experiment) {
			$this->db->delete('viewpermission','id_experiment='.$id_experiment);
		}
		
		function retrievePermissionDisableByIdUser($idUser) {
			$this->db->execute("SELECT distinct id
								FROM experiment
								WHERE id NOT IN (select distinct id_experiment from viewpermission where id_user='".$idUser."')");
			$result = $this->db->fetchrowset();
			return $result;
		}
		
		function retrieveViewPermissionByIdUser($idUser) {
			$this->db->execute("SELECT id_experiment FROM viewpermission WHERE id_user='".$idUser."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
		}
		
			
		function retrieveViewPermissionByIdExperiment($idExperiment) {
			$this->db->execute("SELECT * FROM viewpermission WHERE id_experiment='".$idExperiment."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function verifyPermissionEnable($iduser, $idexperiment) {
			$this->db->execute("SELECT * FROM viewpermission WHERE id_experiment='".$idexperiment."' and id_user='".$iduser."'");
			$result = $this->db->fetchrow();
			if ($result) {
				if (count($result)!=0) {
				return $result;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
		}
		
		function createList() {
			$list = array();
			$list['id_user'] = $this->viewPermission->id_user;
			$list['id_experiment'] = $this->viewPermission->id_experiment;
			return $list;
			
		}
		
}



?>