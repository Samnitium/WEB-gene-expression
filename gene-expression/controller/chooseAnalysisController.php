<?php


	include_once ('../template/cls_fast_template.php');
	include('../logic/logicExperiment.php');
	include('../logic/logicAnalysis.php');
	
	
	session_start();
	$tlp = new FastTemplate("../view");
	if (isset($_SESSION['iduser'])) {
		if (isset($_GET['operation']) && ((isset($_GET['id']) || isset($_POST['experiment'])))) {
			$_SESSION['page_corrent'] = 'chooseAnalysisController.php';
			$tlp->define( array('chooseAnalysis'=>"chooseAnalysis.html", 'row'=>"rowAnalysisToDelete.html"));
			if ($_SESSION['type']=="superuser") {
				$tlp->assign('HOME',"superUserChoiceController.php");
			} else {
				$tlp->assign('HOME',"userChoiceController.php");
			}
			
			if ($_GET['operation']=='delete') {
				$tlp->assign('OPERATION',"delete");
			} else if ($_GET['operation']=='view') {
				$tlp->assign('OPERATION',"view");
			}
			$le = new LogicExperiment();
			if (isset($_GET['id']) &&  $_SESSION['type']=="superuser") {
				$tlp->assign('ACTION',"deleteAnalysisController.php");
				$experiment = $le->retrieveExperimentById($_GET['id']);
			} else if (isset($_POST['experiment'])) {
				if (trim($_POST['experiment'])!="") {
					$ex = explode(", ", $_POST['experiment']);
					$experiment = $le->retrieveExperimentById($ex[0]);
					$tlp->assign('ACTION',"settingThresholdController.php?idexperiment=".$ex[0]);
				} else {
					header("Location: userChoiceController.php");
				}
			} else {
				header("Location: userChoiceController.php");
			}  
			$le->db->close();
			if ($experiment!=NULL) {
				$tlp->assign('NAME_EXPERIMENT',$experiment->name);
				$la = new logicAnalysis();
				$analysis = $la->retrieveAnalysisByIdExperiment($experiment->id);
				$la->db->close();
				if ($analysis!=NULL && count($analysis)!=0) {
					foreach($analysis as $an) {
						$tlp -> assign(array('ID'=>$an['id'].",", 'NAME_ANALYSIS'=>$an['name'].",", 'DATE'=> $an['date']));
						$tlp->parse('ANALYSIS',".row");				
					}	
				} else {
					$tlp -> assign(array('ID'=>"", 'NAME_ANALYSIS'=>"", 'DATE'=>""));
					$tlp->parse('ANALYSIS',".row");	
				}
		
			} else {
				header("Location: userChoiceController.php");
			}
		
	
		
			$tlp->parse('STATE','chooseAnalysis');
	
			Header("Content-type: text/html");
			$tlp->FastPrint();
		} else {
				header("Location: userChoiceController.php");
		}
	}
	else {
		header("Location: pageUnauthorized.php");
	}	

?>