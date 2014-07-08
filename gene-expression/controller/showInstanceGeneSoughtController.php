<?php

	include('../template/cls_fast_template.php');
	include('../logic/logicAnalysis.php');
	include('../logic/logicAnalysisInstance.php');
	include('../logic/logicGene.php');
	include('../logic/logicExperiment.php');
		
	session_start();
	if(isset($_SESSION['iduser'])) {
		if (isset($_POST['name_genesymbol'])  && isset($_GET['idexperiment']) && isset($_SESSION['analysis']) && isset($_GET['numberPvalue']) &&
			isset($_GET['numberFoldChange']) && isset($_GET['thresholdPvalue']) && isset($_GET['thresholdFoldChange']) && isset($_SESSION['listGene'])) {
			$le = new logicExperiment();
			$experiment = $le->retrieveExperimentById($_GET['idexperiment']);
			$le->db->close();
			if (trim($_POST['name_genesymbol'])=="") {
				$_SESSION['message_search'] = "Please, insert gene symbol";
				header("Location: showAnalysisList.php?idexperiment=".$experiment->id."&numberPvalue=".$_GET['numberPvalue']."&numberFoldChange=".$_GET['numberFoldChange']."&thresholdPvalue=".$_GET['thresholdPvalue']."&thresholdFoldChange=".$_GET['thresholdFoldChange']);
			} else {
				$gene = trim($_POST['name_genesymbol']);
				$tlp = new FastTemplate("../view");
				$tlp->define(array('analysisList' => "showViewAnalysisList.html", 'rowComplex'=>"rowComplexAnalysis.html", 'nameAnalysis'=>"nameAnalysisRow.html", 'namePvalueFoldChange'=>"namePvalueFoldChangeRow.html"));
		    	$tlp->assign('NAME_EXPERIMENT',$experiment->name);
				if ($_SESSION['type']=='superuser') {
					$tlp->assign('HOME',"superUserChoiceController.php");
				} else $tlp->assign('HOME',"userChoiceController.php");
				$serAnalysis = unserialize($_SESSION['analysis']);
				$pvalue = $_GET['numberPvalue'];
				$foldchange = $_GET['numberFoldChange'];
				$lg = new logicGene();
				$rowInstance = "";
				$listGene = unserialize($_SESSION['listGene']);
				$presence = false;
				$j = 0;
				while($j<count($listGene) && !($presence)) {
					if ($listGene[$j]['geneSymbol']==$gene) {
						$presence = true;
					}
					$j++;
				}
				if ($lg->retrieveGeneByGeneSymbol($gene)!=NULL && $presence) {
					$rowInstance = $rowInstance."<td><a href='showGene.php?gene_symbol=".$gene."' target='_blank' >".$gene."</a></td>";
				} else {
					$rowInstance = $rowInstance."<td></td>";
				}
				$lg->db->close();
				$lai = new LogicAnalysisInstance();
				foreach ($serAnalysis as $an) {
					$ex = explode(", ", $an);
					$tlp->assign('NAME_ANALYSIS',$ex[1]);
					$tlp->parse('ROW_NAME_ANALYSIS','.nameAnalysis');
					$tlp->assign(array('LINK_PVALUE'=>"", 'LINK_FOLDCHANGE'=>"")); 
					$tlp->parse('ROW_NAME_PVALUE_FOLDCHANGE', '.namePvalueFoldChange');
					if ($pvalue=="" && $foldchange=="") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);					
					} else if ($_GET['thresholdPvalue']=='up' && $foldchange=="") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Up_All($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($_GET['thresholdPvalue']=='down' && $foldchange=="") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Down_All($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($_GET['thresholdPvalue']=='range' && $foldchange=="") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Range_All($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($pvalue=="" && $_GET['thresholdFoldChange']=="up") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All_Up($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($pvalue=="" && $_GET['thresholdFoldChange']=="down") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All_Down($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($pvalue=="" && $_GET['thresholdFoldChange']=="range") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All_Range($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($_GET['thresholdPvalue']=='up' && $_GET['thresholdFoldChange']=='up') {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Up_Up($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($_GET['thresholdPvalue']=='up' && $_GET['thresholdFoldChange']=='down') {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Up_Down($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($_GET['thresholdPvalue']=='up' && $_GET['thresholdFoldChange']=='range') {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Up_Range($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($_GET['thresholdPvalue']=='down' && $_GET['thresholdFoldChange']=="up") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Down_Up($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($_GET['thresholdPvalue']=='down' && $_GET['thresholdFoldChange']=="range") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Down_Range($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($_GET['thresholdPvalue']=='down' && $_GET['thresholdFoldChange']=="down") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Down_Down($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($_GET['thresholdPvalue']=='range' && $_GET['thresholdFoldChange']=="range") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Range_Range($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} else if ($_GET['thresholdPvalue']=='range' && $_GET['thresholdFoldChange']=="up") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Range_Up($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					}  else if ($_GET['thresholdPvalue']=='range' && $_GET['thresholdFoldChange']=="down") {
						$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Range_Down($_GET['idexperiment'],$ex[0],$gene,$pvalue,$foldchange);
					} 		
					if ($analysisList!=NULL) {
						$rowInstance = $rowInstance."<td>".$analysisList['p_value_string']."</td><td>".$analysisList['foldChange']."</td>";																
					} else {
						$rowInstance = $rowInstance."<td></td><td></td>";
					}
		
				}
						
				$tlp->assign('INSTANCE_ROW',$rowInstance);
				$tlp->parse('ROW',".rowComplex");
				$tlp->assign('ACTION_SEARCH',"showInstanceGeneSoughtController.php?idexperiment=".$experiment->id."&numberPvalue=".$_GET['numberPvalue']."&numberFoldChange=".$_GET['numberFoldChange']."&thresholdPvalue=".$_GET['thresholdPvalue']."&thresholdFoldChange=".$_GET['thresholdFoldChange']);
				$lai->db->close();
				$tlp->parse('STATE',"analysisList");
				Header("Content-type: text/html");
				$tlp->FastPrint();
			}
			
		} else {
			header("Location: userChoiceController.php");
		}
	} else {
		header("Location: pageUnauthorized.php");
	}
	


?>