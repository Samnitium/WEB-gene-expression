<?php

	include('../logic/logicViewPermission.php');
	include('../logic/logicExperiment.php');
	include('../logic/logicAnalysis.php');
	
	
	session_start();
	if(isset($_SESSION['iduser'])) {
		$tlp = new FastTemplate("../flow");
		$tlp->define(array('experimentList' => "experimentslist.html", 'experiment' => "experiment.html"));
		$vpLogic = new logicViewPermission();
		$eLogic = new logicExperiment();
		
		$viewPermission = $vpLogic -> retrieveWiewPermissionByIdUser($iduser);
		
		foreach ($viewPermission as $e) {
			$experiment = $eLogic -> retrieveExperimentById($e);
			$tlp -> assign(array('NAME'=>$experiment->name, 'DATE'=> $experiment->date));
			$tlp->parse('EXPERIMENT',".experiment");
		}
		$tlp->parse('STATE',".experimentList.html");
		Header("Content-type: text/html");
		$tlp->FastPrint();	
		
		
	}
	

?>