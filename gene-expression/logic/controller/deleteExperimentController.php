<?php

	include('../logic/logicExperiment.php');
	include('../logic/logicViewPermission.php');
	
	session_start();

	if(isset($_SESSION['iduser']) && $_SESSION['type']=='superuser') {
		if (isset($_GET['id'])) {
			$vp = new LogicViewPermission();
			$eLogic = new logicExperiment();
			$eLogic->deleteExperimentById($_GET['id']);
			$vp->deleteViewPermissionByIdExperiment($_GET['id']);
			$eLogic->db->close();
			$vp->db->close();
		}
		header("Location: experimentsToDeleteController.php");	
	}
	
	else {
		header("Location: pageUnauthorized.php");
	}
	
	
		
		
	
	
?>