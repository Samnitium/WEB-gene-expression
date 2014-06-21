<?php


	include('../template/cls_fast_template.php');
	
	
	session_start();
	if(isset($_SESSION['iduser']) && $_SESSION['type']=="superuser") {
		$_SESSION['page_corrent'] = 'superUserChoiceController.php';
		$tlp = new FastTemplate("../view");
		$tlp->define(array('operationList'=>"operationChoiceList.html"));
		$tlp->assign(array('INSERT'=>"insertExperimentController.php", 'DELETE'=>"", 'PERMISSION'=>"", 'SHOW'=>"userChoiceController.php"));
		
		$tlp->parse('STATE',"operationList");
	
		Header("Content-type: text/html");
		$tlp->FastPrint();
	}
	else {
		header("Location: pageUnauthorized.php");
	}	
		
		
	
	

?>