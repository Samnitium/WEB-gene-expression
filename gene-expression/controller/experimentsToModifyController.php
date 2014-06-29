<?php
	include('../template/cls_fast_template.php');
	include('../logic/logicExperiment.php');
	
	
	
	session_start();
	if(isset($_SESSION['iduser']) && $_SESSION['type']=='superuser') {
		$_SESSION['page_corrent'] = "experimentsToModifyController.php";
		$eLogic = new logicExperiment();
		$tlp = new FastTemplate("../view");
		$tlp->define(array('experimentList' => "experimentList.html", 'experiment' => "experiment.html"));
		$tlp->assign('ACTION',"modifyExperimentController.php");
		$eLogic = new logicExperiment();
		$tlp->assign('HOME',"superUserChoiceController.php");
		$experiments = $eLogic->retrieveAll();
		if (isset($experiments) && count($experiments)!=0) {
			foreach ($experiments as $exp) {
				$tlp -> assign(array('ID'=>$exp['id'], 'NAME'=>$exp['name'], 'DATE'=> $exp['date']));
				$tlp->parse('EXPERIMENT',".experiment");
			}
			
		} 
			
		$eLogic->db->close();
		$tlp->parse('STATE',"experimentList");
		Header("Content-type: text/html");
		$tlp->FastPrint();	
	}
	
	else {
		header("Location: pageUnauthorized.php");
	}
	















?>