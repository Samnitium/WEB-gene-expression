<?php

	include("../logic/logicExperiment.php");
	include_once ('../template/cls_fast_template.php');

	session_start();
	
	$tlp = new FastTemplate("../view");
	if (isset($_SESSION['iduser']) &&  $_SESSION['type']=="superuser") {
		$_SESSION['page_corrent'] = 'addAnalysisController.php';
		if(!(isset($_POST['name']) && trim($_POST['name'])!="")) {
			$_SESSION['empty'] = "<div class='alert alert-danger'>Please, enter the experiment's name </div>";
			header("Location: insertExperimentController.php");
		} else {
			
			$le = new LogicExperiment();
			if ($_SESSION['insert_experiment']==true) {
				$experiment = new Experiment();
				$experiment->name = $_POST['name'];
				$experiment->date = date("Y-m-d", time());
				$le->DTO->setValue('experiment',$experiment);
				$le->insertExperiment();
				$_SESSION['insert_experiment'] = false;
			}
			$_SESSION['idexperiment']=$le->db->insertedid();
			$le->db->close();
			$tlp->define( array('addAnalysis'=>"addAnalysis.html"));
			if (isset($_SESSION['error_upload'])) {
				$tlp->assign('MESSAGE_UPLOAD',$_SESSION['error_upload']);
				$_SESSION['error_upload'] = "";
			} else $tlp->assign('MESSAGE_UPLOAD',"");
			$tlp->assign('HOME',"superUserChoiceController.php");
			$tlp->assign('NAME_EXPERIMENT',$_POST['name']);
			$tlp->assign('ACTION',"testuploadController.php");
			$tlp->parse('STATE','addAnalysis');
			Header("Content-type: text/html");
			$tlp->FastPrint();	
		}
	
		
	}
	else {
		header("Location: pageUnauthorized.php");
	}

?>