<?php

	include('../model/experiment.php');
	include('logic.php');
	
	class LogicExperiment extends Logic {

		var $experiment;
	
		function __construct() {
			parent::__construct();
			$this->experiment = null;	
		}
		
		
		public function __get($value) {
			return $this->$value;
		}
	
		public function __set($name,$value) {
			$this->$name = $value;
		}	
	
		function insertExperiment() {
			$this->user = $this->DTO->getValue('experiment');
			$list = $this->createList();
			$this->db->insert('experiment',$list);
		}
		
		function deleteExperimentById() {
			$this->user = $this->DTO->getValue('experiment');
			$this->db->delete('experiment','id='.$this->experiment->id);
		}
		
		function retrieveUserById($idexperiment) {
			$this->db->execute("SELECT * FROM experiment WHERE id='".$idexperiment."'");
			$result = $this->db->fetchrow();
			if ($result) {
				if (count($result)!=0) {
				$experiment = new Experiment();
				$experiment->id = $idexperiment;
				$experiment->name = $result['name'];
				$experiment->date = $result['date'];
				return $experiment;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function createList() {
			$list = array();
			$list['id'] = $this->experiment->id;
			$list['name'] = $this->experiment->name;
			$list['date'] = $this->experiment->date;
			return $list;
			
		}
		
	}

?>