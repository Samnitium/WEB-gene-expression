<?php

	
	include('../template/cls_fast_template.php');
	
	session_start();
	if(isset($_SESSION['iduser'])) {
		if (isset($_POST['experiment']) && $_POST['experiment']!="") {
			$exp = explode(", ", $_POST['experiment']);
			$_SESSION['page_corrent'] = "settingThresholdController.php";
			$tlp = new FastTemplate("../view");
			$tlp->define(array('threshold' => "settingThreshold.html"));
		    $tlp->assign('NAME_EXPERIMENT',$exp[1]);
			if ($_SESSION['type']=='superuser') {
				$tlp->assign('HOME',"superUserChoiceController.php");
			} else $tlp->assign('HOME',"userChoiceController.php");
			
			if(isset($_SESSION['error']) && $_SESSION['error']!=NULL) {
				$tlp->assign('MESSAGE_ERROR',$_SESSION['error']);
				$_SESSION['error'] = NULL;	
			} else {
				$tlp->assign('MESSAGE_ERROR',"");				
			}
		 	$tlp->assign('ACTION',"showAnalysisOfExperiment.php?idexperiment=".$exp[0]);
	
			$tlp->parse('STATE',"threshold");
			Header("Content-type: text/html");
			$tlp->FastPrint();
		} else {
			header("Location: userChoiceController.php");
		}	
	}
	
	else {
		header("Location: pageUnauthorized.php");
	}
	
	
		
		
	
	

?>