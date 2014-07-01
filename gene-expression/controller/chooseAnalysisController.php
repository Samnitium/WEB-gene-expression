<?php


	include_once ('../template/cls_fast_template.php');
	include('../logic/logicExperiment.php');
	include('../logic/logicAnalysis.php');
	
	
	session_start();
	$tlp = new FastTemplate("../view");
	if (isset($_SESSION['iduser']) && $_SESSION['type']=="superuser") {
		if (isset($_GET['id'])) {
			$_SESSION['page_corrent'] = 'chooseAnalysisController.php';
			$tlp->define( array('chooseAnalysis'=>"chooseAnalysis.html", 'row'=>"rowAnalysisToDelete.html"));
			$tlp->assign('HOME',"superUserChoiceController.php");
			$tlp->assign('ACTION',"deleteAnalysisController.php");
			$le = new LogicExperiment();
			$experiment = $le->retrieveExperimentById($_GET['id']);
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
				header("Location: experimentsToDeleteController.php");
			}
		
	
		
			$tlp->parse('STATE','chooseAnalysis');
	
			Header("Content-type: text/html");
			$tlp->FastPrint();
		} else {
				header("Location: experimentsToDeleteController.php");
		}
	}
	else {
		header("Location: pageUnauthorized.php");
	}	

?>