<?php

	
	include('../template/cls_fast_template.php');
	include('../logic/LogicExperiment.php');
	
	session_start();
	if(isset($_SESSION['iduser'])) {
		if (isset($_GET['idexperiment']) && isset($_POST['analysis'])) {
			$le = new LogicExperiment();
			$experiment = $le->retrieveExperimentById($_GET['idexperiment']);
			$le->db->close();
			$_SESSION['page_corrent'] = "settingThresholdController.php";
			$tlp = new FastTemplate("../view");
			$tlp->define(array('threshold' => "settingThreshold.html"));
		    $tlp->assign('NAME_EXPERIMENT',$experiment->name);
			if ($_SESSION['type']=='superuser') {
				$tlp->assign('HOME',"superUserChoiceController.php");
			} else $tlp->assign('HOME',"userChoiceController.php");
			
			if(isset($_SESSION['error']) && $_SESSION['error']!=NULL) {
				$tlp->assign('MESSAGE_ERROR',$_SESSION['error']);
				$_SESSION['error'] = NULL;	
			} else {
				$tlp->assign('MESSAGE_ERROR',"");				
			}
			/*$array= array();
			foreach($_POST['analysis'] as $el) {
				$el = str_replace(", ","-", $el);
				array_push($array,$el);	
			}*/
			$serAnalysis =  serialize($_POST['analysis']);
			$_SESSION['analysis'] = $serAnalysis;
		 	$tlp->assign('ACTION',"showAnalysisList.php?idexperiment=".$experiment->id);
	
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