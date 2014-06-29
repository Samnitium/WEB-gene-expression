<?php

	
	include('../template/cls_fast_template.php');
	include('../logic/logicAnalysis.php');
	include('../logic/logicAnalysisInstance.php');
	include('../logic/logicExperiment.php');
		
	session_start();
	if(isset($_SESSION['iduser'])) {
		if (isset($_POST['p_value']) && isset($_POST['fold_change']) && isset($_GET['idexperiment'])) {
			
			if($_POST['p_value']=="" || $_POST['fold_change']=="") {
				$_SESSION['error'] = "you must enter a threshold in both fields";	
				header("Location: settingThresholdController.php");
			}
			$pvalue = $_POST['p_value'];
			$foldchange = $_POST['fold_change'];
			$_SESSION['page_corrent'] = "showAnalysisList.php";
			$le = new LogicExperiment();
			$experiment = $le->retrieveExperimentById($_GET['idexperiment']);
			$le->db->close();
			if ($experiment!=NULL) {
				$tlp = new FastTemplate("../view");
				$tlp->define(array('analysisList' => "showViewAnalysisList.html", 'analysis' => "rowAnalysis.html"));
		    	$tlp->assign('NAME_EXPERIMENT',$experiment->name);
				if ($_SESSION['type']=='superuser') {
					$tlp->assign('HOME',"superUserChoiceController.php");
				} else $tlp->assign('HOME',"userChoiceController.php");
				$lai = new LogicAnalysisInstance();
				$analysisList = $lai->retrieveAnalysisInstanceByIdExperimentThreshold($_GET['idexperiment'],$pvalue,$foldchange); 
				if (isset($analysisList) && count($analysisList)!=0) {
					foreach ($analysisList as $an) {	
						$tlp -> assign(array('GENE_SYMBOL'=>"<a href='showGene.php?gene_symbol=".$an['geneSymbol']."'>".$an['geneSymbol']."</a>", 'P_VALUE'=>$an['p_value'], 'FOLD_CHANGE'=>$an['foldChange'], 'NAME'=>$an['name'], 'DATE'=>$an['date']));
						$tlp->parse('ROW',".analysis");
					}
				} else {
					$tlp -> assign(array('GENE_SYMBOL'=>"", 'P_VALUE'=>"", 'FOLD_CHANGE'=>"", 'NAME'=>"", 'DATE'=>""));
					$tlp->parse('ROW',".analysis");
				}
		
		 
				$lai->db->close();
	
				$tlp->parse('STATE',"analysisList");
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