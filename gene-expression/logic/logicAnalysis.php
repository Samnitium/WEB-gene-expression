<?php

	
	include('../model/analysis.php');
	include_once('logic.php');
	
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
			$this->db->delete('analysis','id='.$this->analysis->id);
		}
		
		function deleteAnalysisByIdExperiment($idexperiment) {
			$this->db->delete('analysis','id_experiment='.$idexperiment);
		}
		
		function retrieveAnalysisByIdExperiment($idexperiment) {
			$this->db->execute("SELECT * FROM analysis WHERE id_experiment='".$idexperiment."'");
			$result = $this->db->fetchrowset();
			return $result;
		}
		
		function retrieveAnalysisById($idanalysis) {
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
				$analysis->date = $result['date'];
				$analysis->id_experiment = $result['id_experiment'];
				return $analysis;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function createList() {
			$list = array();
			$list['geneSymbol'] = $this->analysis->geneSymbol;
			$list['p_value'] = $this->analysis->p_value;
			$list['foldChange'] = $this->analysis->foldChange;
			$list['name'] = $this->analysis->name;
			$list['date'] = $this->analysis->date;
			$list['id_experiment'] = $this->analysis->id_experiment;
			return $list;
			
		}
		
	}



?>