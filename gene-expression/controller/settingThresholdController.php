<?php

	
	include('../template/cls_fast_template.php');
	include('../logic/logicExperiment.php');
	include('../logic/logicAnalysis.php');
	
	session_start();
	if(isset($_SESSION['iduser'])) {
		if (isset($_GET['idexperiment']) && (isset($_SESSION['analysis']) || (isset($_POST['analysis']) && (!(count($_POST['analysis'])==1 && trim($_POST['analysis'][0])==""))))) {
			if ((isset($_POST['analysis']) && count($_POST['analysis'])==1 && trim($_POST['analysis'][0])=="")) {
				header("Location: userChoiceController.php");
			}
			$le = new LogicExperiment();
			$la = new LogicAnalysis();
			$experiment = $le->retrieveExperimentById($_GET['idexperiment']);
			$le->db->close();
			if ($experiment!=NULL) {
				$_SESSION['page_corrent'] = "settingThresholdController.php";
				if(isset($_SESSION['analysis']) && !(isset($_POST['analysis']))) {
					$serAnalysis = unserialize($_SESSION['analysis']);
					foreach($serAnalysis as $an) {
						$ean = explode(", ", $an);
						$ele = $la->retrieveAnalysisByIdExperimentAndIdAnalysis($experiment->id, $ean[0]);
						if ($ele==NULL) {
							$la->db->close();
							header("Location: userChoiceController.php");
						}
					}
				}
				$la->db->close();
				$tlp = new FastTemplate("../view");
				$tlp->define(array('threshold' => "settingThreshold.html"));
		   		 $tlp->assign('NAME_EXPERIMENT',$experiment->name);
				if ($_SESSION['type']=='superuser') {
					$tlp->assign('HOME',"superUserChoiceController.php");
				} else $tlp->assign('HOME',"userChoiceController.php");
			
				if(isset($_SESSION['error']) && $_SESSION['error']!=NULL) {
					$tlp->assign('MESSAGE_ERROR',$_SESSION['error']);
					$_SESSION['error'] = NULL;	
				} else {
					$tlp->assign('MESSAGE_ERROR',"");				
				}
			/*$array= array();
			foreach($_POST['analysis'] as $el) {
				$el = str_replace(", ","-", $el);
				array_push($array,$el);	
			}*/
				if (isset($_POST['analysis'])) {
					$serAnalysis =  serialize($_POST['analysis']);
					$_SESSION['analysis'] = $serAnalysis;
				}
		 		$tlp->assign('ACTION',"showAnalysisList.php?idexperiment=".$experiment->id);
			
				$tlp->parse('STATE',"threshold");
				Header("Content-type: text/html");
				$tlp->FastPrint();
			} else {
				header("Location: userChoiceController.php");	
			}
		} else {
			header("Location: userChoiceController.php");
		}	
	}
	
	else {
		header("Location: pageUnauthorized.php");
	}
	
	
		
		
	
	

?>