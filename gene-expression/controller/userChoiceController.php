<?php

	include('../logic/logicViewPermission.php');
	include('../logic/logicExperiment.php');
	include('../template/cls_fast_template.php');
	
	
	session_start();
	if(isset($_SESSION['iduser'])) {
		$tlp = new FastTemplate("../view");
		$tlp->define(array('experimentList' => "experimentlist.html", 'experiment' => "experiment.html"));
		$tlp->assign('ACTION',"");
		$vpLogic = new logicViewPermission();
		$eLogic = new logicExperiment();
		
		$viewPermission = $vpLogic -> retrieveViewPermissionByIdUser($_SESSION['iduser']);
		
		foreach ($viewPermission as $e) {
			
			$experiment = $eLogic -> retrieveExperimentById($e['id_experiment']);
			if (isset($experiment)) {
				$tlp -> assign(array('NAME'=>$experiment->name, 'DATE'=> $experiment->date));
				$tlp->parse('EXPERIMENT',".experiment");
			}
		}
		$tlp->parse('STATE',"experimentList");
		Header("Content-type: text/html");
		$tlp->FastPrint();	
		
		
	}
	

?>