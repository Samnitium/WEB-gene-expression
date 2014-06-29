<?php

	include('../logic/logicViewPermission.php');
	include('../logic/logicExperiment.php');
	include('../template/cls_fast_template.php');
	include('../logic/logicUser.php');
	
	session_start();
	if(isset($_SESSION['iduser'])) {
		$_SESSION['page_corrent'] = "userChoiceController.php";
		$tlp = new FastTemplate("../view");
		$tlp->define(array('experimentList' => "experimentList.html", 'experiment' => "experiment.html"));
		$lu = new LogicUser();
		$tlp->assign('ACTION',"settingThresholdController.php");
		$eLogic = new logicExperiment();
		$user = $lu->retrieveUserById($_SESSION['iduser']);
		$lu->db->close();
		if ($user->type=="superuser") {
			$tlp->assign('HOME',"superUserChoiceController.php");
			$experiments = $eLogic->retrieveAll();
			if (isset($experiments) && count($experiments)!=0) {
					foreach ($experiments as $exp) {	
						$tlp -> assign(array('ID'=>$exp['id'], 'NAME'=>$exp['name'], 'DATE'=> $exp['date']));
						$tlp->parse('EXPERIMENT',".experiment");
					}
			}
		} else {
			$tlp->assign('HOME',"");
			$vpLogic = new logicViewPermission();
			$viewPermission = $vpLogic -> retrieveViewPermissionByIdUser($_SESSION['iduser']);
			if (isset($viewPermission) && count($viewPermission)!=0) {
				foreach ($viewPermission as $e) {	
					$experiment = $eLogic -> retrieveExperimentById($e['id_experiment']);
					if (isset($experiment)) {
						$tlp -> assign(array('ID'=>$experiment->id,'NAME'=>$experiment->name, 'DATE'=> $experiment->date));
						$tlp->parse('EXPERIMENT',".experiment");
					}
				}
			}
			$vpLogic->db->close();
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