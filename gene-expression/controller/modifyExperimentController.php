<?php

	include("../logic/logicExperiment.php");
	include_once ('../template/cls_fast_template.php');

	session_start();
	
	$tlp = new FastTemplate("../view");
	if (isset($_SESSION['iduser']) &&  $_SESSION['type']=="superuser") {
		$_SESSION['page_corrent'] = 'modifyExperimentController.php';
		if(isset($_POST['experiment']) || (isset($_SESSION['experiment']) && $_SESSION['experiment']!=NULL)) {
			if (isset($_POST['experiment'])) {
				 $_SESSION['experiment'] = $_POST['experiment']; 
			} else {
				$_POST['experiment'] = $_SESSION['experiment'];
			}
			$exp = explode(", ", $_POST['experiment']);
			$tlp->define( array('modifyExperiment'=>"modifyExperiment.html"));
			if (isset($_SESSION['error_upload'])) {
				$tlp->assign('MESSAGE_ERROR',$_SESSION['error_upload']);
				$_SESSION['error_upload'] = "";
			} else $tlp->assign('MESSAGE_ERROR',"");
			$tlp->assign('HOME',"superUserChoiceController.php");
			$tlp->assign('NAME_EXPERIMENT',$exp[1]);
			$tlp->assign('ACTION',"modifyExperimentDoneController.php?idexperiment=".$exp[0]);
			$tlp->parse('STATE','modifyExperiment');
			Header("Content-type: text/html");
			$tlp->FastPrint();	
			
		} else {
			header("Location: experimentsToModifyController.php");
		} 
	
	} else {
		header("Location: pageUnauthorized.php");
	}

?>