<?php

	
	include('../template/cls_fast_template.php');
	include('../logic/logicAnalysis.php');
	include('../logic/logicAnalysisInstance.php');
	include('../logic/logicExperiment.php');
		
	session_start();
	if(isset($_SESSION['iduser'])) {
		if (isset($_POST['numberPvalue']) && isset($_POST['numberFoldChange'])) {
			
			
			/*if($_POST['p_value']=="" || $_POST['fold_change']=="") {
				$_SESSION['error'] = "you must enter a threshold in both fields";	
				header("Location: settingThresholdController.php");
			}*/
			$pvalue = $_POST['numberPvalue'];
			$foldchange = $_POST['numberFoldChange'];
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
				if ($pvalue=="" && $foldchange=="") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All($_GET['idexperiment'],$pvalue,$foldchange);					
				} else if ($_POST['thresholdPvalue']=='up' && $foldchange=="") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Up_All($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($_POST['thresholdPvalue']=='down' && $foldchange=="") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Down_All($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($_POST['thresholdPvalue']=='range' && $foldchange=="") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Range_All($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($pvalue=="" && $_POST['thresholdFoldChange']=="up") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All_Up($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($pvalue=="" && $_POST['thresholdFoldChange']=="down") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All_Down($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($pvalue=="" && $_POST['thresholdFoldChange']=="range") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All_Range($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($_POST['thresholdPvalue']=='up' && $_POST['thresholdFoldChange']=='up') {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Up_Up($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($_POST['thresholdPvalue']=='up' && $_POST['thresholdFoldChange']=='down') {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Up_Down($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($_POST['thresholdPvalue']=='up' && $_POST['thresholdFoldChange']=='range') {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Up_Range($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($_POST['thresholdPvalue']=='down' && $_POST['thresholdFoldChange']=="up") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Down_Up($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($_POST['thresholdPvalue']=='down' && $_POST['thresholdFoldChange']=="range") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Down_Range($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($_POST['thresholdPvalue']=='down' && $_POST['thresholdFoldChange']=="down") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Down_Down($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($_POST['thresholdPvalue']=='range' && $_POST['thresholdFoldChange']=="range") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Range_Range($_GET['idexperiment'],$pvalue,$foldchange);
				} else if ($_POST['thresholdPvalue']=='range' && $_POST['thresholdFoldChange']=="up") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Range_Up($_GET['idexperiment'],$pvalue,$foldchange);
				}  else if ($_POST['thresholdPvalue']=='range' && $_POST['thresholdFoldChange']=="down") {
					$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Range_Down($_GET['idexperiment'],$pvalue,$foldchange);
				} 
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