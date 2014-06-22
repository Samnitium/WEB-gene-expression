<?php

	include("../logic/logicExperiment.php");
	include_once ('../template/cls_fast_template.php');

	session_start();
	
	$tlp = new FastTemplate("../view");
	if (isset($_SESSION['iduser']) &&  $_SESSION['type']=="superuser") {
		$_SESSION['page_corrent'] = 'addAnalysisController.php';
		if(!(isset($_POST['name']) && trim($_POST['name'])!="")) {
			$_SESSION['empty'] = "fill the field of the experiment's name";
			header("Location: insertExperimentController.php");
		} else {
			$le = new LogicExperiment();
			$experiment = new Experiment();
			$experiment->name = $_POST['name'];
			$experiment->date = date("Y-m-d", time());
			$le->DTO->setValue('experiment',$experiment);
			$le->insertExperiment();
			$le->db->close();
			$tlp->define( array('addAnalysis'=>"addAnalysis.html"));
			$tlp->assign('HOME',"superUserChoiceController.php");
			$tlp->assign('NAME_EXPERIMENT',$_POST['name']);
			$tlp->assign('ADD_ANALISYS',"ss");
			$tlp->parse('STATE','addAnalysis');
			Header("Content-type: text/html");
			$tlp->FastPrint();	
		}
	
		
	}
	else {
		header("Location: pageUnauthorized.php");
	}

?>