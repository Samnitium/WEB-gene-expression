<?php

	include('../template/cls_fast_template.php');
	include('../logic/logicExperiment.php');
	
	session_start();
	if(isset($_SESSION['iduser']) && $_SESSION['type']=='superuser') {
		$_SESSION['page_corrent'] = "experimentsToDeleteController.php";
		$tlp = new FastTemplate("../view");
		$tlp->define(array('experimentList' => "experimentToDeleteList.html", 'experiment' => "experimentToDelete.html"));
		$tlp->assign('HOME',"superUserChoiceController.php");
		$tlp->assign('ACTION',"");		
		$eLogic = new logicExperiment();
		$experiments = $eLogic->retrieveAll();
		if (isset($experiments) && count($experiments)!=0) {
			foreach ($experiments as $exp) {	
					$tlp -> assign(array('NAME'=>$exp['name'], 'DATE'=> $exp['date'], 'LINK'=>"<a href='deleteExperimentController.php?id=".$exp['id']."'>Delete</a>", 
										 'LINK_ANALYSIS'=>"<a href='chooseAnalysisController.php?id=".$exp['id']."'>Delete analysis</a>"));
					$tlp->parse('EXPERIMENT',".experiment");
			}
		} else {
		
			$tlp -> assign(array('NAME'=>"", 'DATE'=>"", 'LINK'=>""));
			$tlp->parse('EXPERIMENT',".experiment");
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