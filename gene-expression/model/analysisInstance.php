<?php
	class AnalysisInstance {
	
		var $id_analysis;
		var $geneSymbol;
		var $p_value_string;
		var $p_value;
		var $foldChange;
		
		public function __construct() {
			$this->id_analysis = null;
			$this->geneSymbol = null;
			$this->p_value_string = null;
			$this->p_value = null;
			$this->foldChange = null;
		}
	
	public function __get($value) {
		return $this->$value;
	}
	
	public function __set($name,$value) {
		$this->$name = $value;
	}
	
	
		
}
	
	
?>