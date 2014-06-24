<?php

	
	include('../model/gene.php');
	include_once('logic.php');
	
	class LogicGene extends Logic {

		var $gene;
	
		function __construct() {
			parent::__construct();
			$this->gene = null;	
		}
		
		
		public function __get($value) {
			return $this->$value;
		}
	
		public function __set($name,$value) {
			$this->$name = $value;
		}	
	
		function insertGene() {
			$this->gene = $this->DTO->getValue('gene');
			$list = $this->createList();
			$this->db->insert('gene',$list);
		}
		
		function deleteGeneById() {
			$this->gene= $this->DTO->getValue('gene');
			$this->db = openDb();
			$this->db->delete('gene','id='.$this->gene->id);
			closeDb($db);
		}
		
		function retrieveGeneById($idgene) {
			$this->db->execute("SELECT * FROM gene WHERE id='".$idgene."'");
			$result = $this->db->fetchrow();
			if ($result) {
				if (count($result)!=0) {
				$gene = new Gene();
				$gene->id = $idgene;
				$gene->geneSymbol = $result['geneSymbol'];
				$gene->geneAssignment = $result['geneAssignment'];
				$gene->refSeq = $result['refSeq'];
				return $gene;
				} else {
					return NULL;
				}
			} else {
				return NULL;
			}
			
		}
		
		function retrieveGeneByGeneSymbol($geneSymbol) {
			$this->db->execute("SELECT * FROM gene WHERE geneSymbol='".$geneSymbol."'");
			$result = $this->db->fetchrow();
			return $result;
		}
		
		
		function createList() {
			$list = array();
			$list['geneSymbol'] = $this->gene->geneSymbol;
			$list['geneAssignment'] = $this->gene->geneAssignment;
			$list['refSeq'] = $this->gene->refSeq;
			return $list;
			
		}
		
	}



?>