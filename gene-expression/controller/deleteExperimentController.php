<?php

	include('../logic/logicExperiment.php');
	include('../logic/logicViewPermission.php');
	include('../logic/logicAnalysis.php');
	include('../logic/logicAnalysisInstance.php');
	
		
	session_start();

	if(isset($_SESSION['iduser']) && $_SESSION['type']=='superuser') {
		if (isset($_GET['id'])) {
			$vp = new LogicViewPermission();
			$la = new LogicAnalysis();
			$eLogic = new logicExperiment();
			$lai = new LogicAnalysisInstance();
			$eLogic->deleteExperimentById($_GET['id']);
			$vp->deleteViewPermissionByIdExperiment($_GET['id']);
			$analysisList = $la-> retrieveAnalysisByIdExperiment($_GET['id']);
			$la->deleteAnalysisByIdExperiment($_GET['id']);
			foreach ($analysisList as $an) {
				$lai->deleteAnalysisInstanceByIdAnalysis($an['id']);
			}
			$la->db->close();
			$eLogic->db->close();
			$vp->db->close();
			$lai->db->close();
		}
		header("Location: experimentsToDeleteController.php");	
	}
	
	else {
		header("Location: pageUnauthorized.php");
	}
	
	
		
		
	
	
?>