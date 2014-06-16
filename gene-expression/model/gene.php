<?php
	class Gene {
	
		var $id;
		var $geneSymbol;
		var $geneAssignment;
		var $refSeq;
		
		
		public function __construct() {
			$this->id = null;
			$this->geneSymbol = null;
			$this->geneAssignment = null;
			$this->refSeq = null;
			
		}
	
	public function __get($value) {
		return $this->$value;
	}
	
	public function __set($name,$value) {
		$this->$name = $value;
	}
	
	
		
}
	
	
	

?>