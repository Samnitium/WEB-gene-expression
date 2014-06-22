<?php

	include('../logic/logicUser.php');
	include('../logic/logicViewPermission.php');
	
	session_start();
	if(isset($_SESSION['iduser']) && $_SESSION['type']=='superuser') {
		if (isset($_GET['iduser']) && isset($_GET['user'])  && isset($_GET['idexperiment']) ) {
				$lv = new LogicViewPermission();
				$vp = new ViewPermission();
				$vp->id_user = $_GET['iduser'];
				$vp->id_experiment = $_GET['idexperiment'];
				$lv->DTO->setValue('viewPermission',$vp);
				$lv->insertViewPermission();
				$lv->db->close();
				header("Location: enablePermissionsController.php?user=".$_GET['user']);
		} else {
			header("Location: selectUserController.php");
		}

	}
	
	else {
		header("Location: pageUnauthorized.php");
	}


?>