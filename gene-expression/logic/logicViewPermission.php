<?php

	
	include('../model/viewPermission.php');
	include('logic.php');
	
	class LogicViewPermission extends Logic {

		var $wiewPermission;
	
		function __construct() {
			parent::__construct();
			$this->wiewPermission = null;	
		}
		
		
		public function __get($value) {
			return $this->$value;
		}
	
		public function __set($name,$value) {
			$this->$name = $value;
		}	
	
		function insertAnalysis() {
			$this->wiewPermission = $this->DTO->getValue('wiewPermission');
			$list = $this->createList();
			$this->db->insert('wiewPermission',$list);
		}
		
		function deleteWiewPermissionByIdUser() {
			$this->wiewPermission= $this->DTO->getValue('wiewPermission');
			$this->db->delete('wiewPermission','id_user='.$this->wiewPermission->id_user);
		}
		function deleteWiewPermissionByIdExperiment() {
			$this->wiewPermission= $this->DTO->getValue('wiewPermission');
			$this->db->delete('wiewPermission','id_experiment='.$this->wiewPermission->id_experiment);
		}
		
		function retrieveWiewPermissionByIdUser($idUser) {
			$this->db->execute("SELECT id_experiment FROM wiewPermission WHERE id_user='".$idUser."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				return $result;
				} else {
					closeDb($db);
					return NULL;
				}
			} else {
				closeDb($db);
				return NULL;
			}
		}
			
			function retrieveWiewPermissionByIdExperiment($idExperiment) {
			$this->db->execute("SELECT * FROM wiewPermission WHERE id_experiment='".$idExperiment."'");
			$result = $this->db->fetchrowset();
			if ($result) {
				if (count($result)!=0) {
				return $result;
				} else {
					closeDb($db);
					return NULL;
				}
			} else {
				closeDb($db);
				return NULL;
			}
			
			}
		
		function createList() {
			$list = array();
			$list['id_user'] = $this->viewPermission->id_user;
			$list['id_experiment'] = $this->viewPermission->ide_experiment;
			return $list;
			
		}
		
}



?>