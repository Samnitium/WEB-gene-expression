<?php
	class Experiment {
	
		var $id;
		var $name;
		var $date;
		
		
		
		public function __construct() {
			$this->id = null;
			$this->name = null;
			$this->date = null;
			
		}
	
	public function __get($value) {
		return $this->$value;
	}
	
	public function __set($name,$value) {
		$this->$name = $value;
	}
	
	
		
}
	
	
	

?>