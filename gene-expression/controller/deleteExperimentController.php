<?php

	include('../logic/logicExperiment.php');
	include('../logic/logicViewPermission.php');
	include('../logic/logicAnalysis.php');
	
	session_start();

	if(isset($_SESSION['iduser']) && $_SESSION['type']=='superuser') {
		if (isset($_GET['id'])) {
			$vp = new LogicViewPermission();
			$la = new LogicAnalysis();
			$eLogic = new logicExperiment();
			$eLogic->deleteExperimentById($_GET['id']);
			$vp->deleteViewPermissionByIdExperiment($_GET['id']);
			$la->deleteAnalysisByIdExperiment($_GET['id']);
			$la->db->close();
			$eLogic->db->close();
			$vp->db->close();
		}
		header("Location: experimentsToDeleteController.php");	
	}
	
	else {
		header("Location: pageUnauthorized.php");
	}
	
	
		
		
	
	
?>