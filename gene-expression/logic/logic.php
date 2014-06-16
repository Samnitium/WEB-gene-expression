<?php
	
	include_once '../util/db.php';
	include_once '../util/DTO.php';

	
	class Logic {
	
		var $db;
		var $DTO;
		
		function __construct() {
			
			$this->db = new db('localhost','gene_expression','root','',true);
			$this->DTO = new DTO();
		}	
	
	}

?>
