<?php

	
	include('../model/user.php');
	include('logic.php');
	
	class LogicAnalysis extends Logic {

		var $analysis;
	
		function __construct() {
			parent::__construct();
			$this->analysis = null;	
		}
		
		
		public function __get($value) {
			return $this->$value;
		}
	
		public function __set($name,$value) {
			$this->$name = $value;
		}	
	
		function insertAnalysis() {
			$this->analysis = $this->DTO->getValue('analysis');
			$list = $this->createList();
			$this->db->insert('analysis',$list);
		}
		
		function deleteAnalysisById() {
			$this->analysis= $this->DTO->getValue('analysis');
			$this->db = openDb();
			$this->db->delete('analysis','id='.$this->analysis->id);
			closeDb($db);
		}
		
		function retrieveAnalysiById($idanalysis) {
			//$this->user = $this->DTO->getValue('user');
			$this->db = openDb();
			$this->db->execute("SELECT * FROM analysis WHERE id='".$idanalysis."'");
			$result = $this->db->fetchrow();
			if ($result) {
				if (count($result)!=0) {
				$analysis = new Analysis();
				$analysis->id = $idanalysis;
				$analysis->geneSymbol = $result['geneSymbol'];
				$analysis->p_value = $result['p_value'];
				$analysis->foldChange = $result['foldChange'];
				$analysis->name = $result['name']; 
				$analysis->data = $result['data'];
				$analysis->id_experiment = $result['id_experiment'];
				closeDb($db);
				return $analysis;
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
			$list['id'] = $this->user->id;
			$list['geneSimbol'] = $this->analysis->geneSymbol;
			$list['p_value'] = $this->analysis->p_value;
			$list['foldChange'] = $this->analysis->foldChange;
			$list['name'] = $this->analysis->name;
			$list['data'] = $this->analysis->tdata;
			$list['id_experiment'] = $this->analysis->id_experiment;
			return $list;
			
		}
		
	}



?>