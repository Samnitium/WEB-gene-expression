<?php

	include('../logic/logicExperiment.php');
	include('../logic/logicViewPermission.php');
	include('../logic/logicAnalysis.php');
	include('../logic/logicAnalysisInstance.php');
	
		
	session_start();

	if(isset($_SESSION['iduser']) && $_SESSION['type']=='superuser') {
		if (isset($_POST['analysis'])) {
			$la = new LogicAnalysis();
			$lai = new LogicAnalysisInstance();
			foreach($_POST['analysis'] as $an){
	    		$ex = explode(", ", $an);
				$la->deleteAnalysisById($ex[0]);
				$lai->deleteAnalysisInstanceByIdAnalysis($ex[0]);
			}
			$la->db->close();
			$lai->db->close();
			header("Location: experimentsToDeleteController.php");	
		} else {
			header("Location: experimentsToDeleteController.php");	
		}
	}
	
	else {
		header("Location: pageUnauthorized.php");
	}
	
	
		
		
	
	
?>