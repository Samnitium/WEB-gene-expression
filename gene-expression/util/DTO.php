<?php

class DTO {
		
	var $DTO;
	
	function __construct() {
		
		$this->DTO = array();
		
	}
		
	public function getValue($name) {
		if (isset($this->DTO[$name])) {
			return $this->DTO[$name];
		}
		else return "";
		
	}

	public function setValue($name, $value) {
		
		$this->DTO[$name] =$value;
		
	}

	public function remove($name) {
		
		$this->DTO[$name] = null;
		
	}
}
?>
