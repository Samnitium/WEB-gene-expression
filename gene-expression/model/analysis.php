<?php
	class Analysis {
	
		var $id;
		var $name;
		var $date;
		var $id_experiment;
		
		
		public function __construct() {
			$this->id = null;
			$this->name = null;
			$this->date = null;
			$this->id_experiment = null;
			
		}
	
	public function __get($value) {
		return $this->$value;
	}
	
	public function __set($name,$value) {
		$this->$name = $value;
	}
	
	
		
}
	
	
	

?>