<?php
	class ViewPermission {
	
		var $id_user;
		var $id_experiment;
		
		public function __construct() {
			$this->id_user = null;
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