<?php

	
	include('../template/cls_fast_template.php');
	include('../logic/logicAnalysis.php');
	include('../logic/logicAnalysisInstance.php');
	include('../logic/logicExperiment.php');
		
	session_start();
	if(isset($_SESSION['iduser'])) {
		if ((isset($_POST['numberPvalue']) || isset($_GET['numberPvalue'])) && (isset($_POST['numberFoldChange']) || isset($_GET['numberFoldChange'])) &&
		     isset($_GET['idexperiment']) && isset($_SESSION['analysis']) && (isset($_POST['thresholdPvalue']) || isset($_GET['thresholdPvalue'])) &&
			 (isset($_POST['numberFoldChange']) || isset($_GET['numberFoldChange']))) {
			$serAnalysis = unserialize($_SESSION['analysis']);
			
			/*if($_POST['p_value']=="" || $_POST['fold_change']=="") {
				$_SESSION['error'] = "you must enter a threshold in both fields";	
				header("Location: settingThresholdController.php");
			}*/
			
			$stamp_analysis = true;
			if (isset($_GET['thresholdPvalue']) && isset($_GET['thresholdFoldChange'])) {
				$_POST['thresholdPvalue'] = $_GET['thresholdPvalue'];
				$_POST['thresholdFoldChange'] = $_GET['thresholdFoldChange'];
			}
			if (isset($_GET['numberPvalue']) && isset($_GET['numberFoldChange'])) {
				$_POST['numberPvalue'] = $_GET['numberPvalue'];
				$_POST['numberFoldChange'] = $_GET['numberFoldChange'];
			}
			$pvalue = $_POST['numberPvalue'];
			$foldchange = $_POST['numberFoldChange'];
			$_SESSION['page_corrent'] = "showAnalysisList.php";
			$le = new LogicExperiment();
			$experiment = $le->retrieveExperimentById($_GET['idexperiment']);
			$le->db->close();
			if ($experiment!=NULL) {
				$tlp = new FastTemplate("../view");
				$tlp->define(array('analysisList' => "showViewAnalysisList.html", 'rowComplex'=>"rowComplexAnalysis.html", 'nameAnalysis'=>"nameAnalysisRow.html", 'namePvalueFoldChange'=>"namePvalueFoldChangeRow.html"));
		    	$tlp->assign('NAME_EXPERIMENT',$experiment->name);
				if ($_SESSION['type']=='superuser') {
					$tlp->assign('HOME',"superUserChoiceController.php");
				} else $tlp->assign('HOME',"userChoiceController.php");
				if (count($serAnalysis)!=0) {
					$lai = new LogicAnalysisInstance();
					if (isset($_GET['order']) && isset($_GET['idanalysis']) && $_GET['order']!="" && $_GET['idanalysis']!="") {
						$listGene =  $lai->retrieveAllGeneByIdExperimentOrderAnalysis($experiment->id,$_GET['order'], $_GET['idanalysis']);
					} else {
						$listGene =  $lai->retrieveAllGeneByIdExperiment($experiment->id);
					}
					if ($listGene!=NULL) {
						if (isset($_GET['number']) && $_GET['number']!="") {
							$i = $_GET['number'];
							$num = $i-300;
							$max = $i+300;
						} else {
							$i = 0;
							$max = 300;
						}
						while ($i<count($listGene) && $i<$max) {
							$gene = $listGene[$i];
							$rowInstance = "";
							if ($gene['geneSymbol']!="") {
								$rowInstance = $rowInstance."<td><a href='showGene.php?gene_symbol=".$gene['geneSymbol']."' target='_blank' >".$gene['geneSymbol']."</a></td>";
							} else {
								$rowInstance = $rowInstance."<td>NA</td>";
							}
							foreach ($serAnalysis as $an) {
								$ex = explode(", ", $an);
								if($stamp_analysis) {
									$tlp->assign('NAME_ANALYSIS',$ex[1]);
									$tlp->parse('ROW_NAME_ANALYSIS','.nameAnalysis');
									$link_pvalue = "showAnalysisList.php?idexperiment=".$experiment->id."&numberPvalue=".$_POST['numberPvalue']."&numberFoldChange=".$_POST['numberFoldChange']."&thresholdPvalue=".$_POST['thresholdPvalue']."&thresholdFoldChange=".$_POST['thresholdFoldChange']."&order=p_value&idanalysis=".$ex[0];
									$link_foldchange = "showAnalysisList.php?idexperiment=".$experiment->id."&numberPvalue=".$_POST['numberPvalue']."&numberFoldChange=".$_POST['numberFoldChange']."&thresholdPvalue=".$_POST['thresholdPvalue']."&thresholdFoldChange=".$_POST['thresholdFoldChange']."&order=foldChange&idanalysis=".$ex[0];
									$tlp->assign(array('LINK_PVALUE'=>$link_pvalue, 'LINK_FOLDCHANGE'=>$link_foldchange));
									$tlp->parse('ROW_NAME_PVALUE_FOLDCHANGE', '.namePvalueFoldChange');
								}
								if ($pvalue=="" && $foldchange=="") {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);					
								} else if ($_POST['thresholdPvalue']=='up' && $foldchange=="") {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Up_All($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($_POST['thresholdPvalue']=='down' && $foldchange=="") {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Down_All($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($_POST['thresholdPvalue']=='range' && $foldchange=="") {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Range_All($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($pvalue=="" && $_POST['thresholdFoldChange']=="up") {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All_Up($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($pvalue=="" && $_POST['thresholdFoldChange']=="down") {
								$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All_Down($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($pvalue=="" && $_POST['thresholdFoldChange']=="range") {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All_Range($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($_POST['thresholdPvalue']=='up' && $_POST['thresholdFoldChange']=='up') {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Up_Up($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($_POST['thresholdPvalue']=='up' && $_POST['thresholdFoldChange']=='down') {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Up_Down($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($_POST['thresholdPvalue']=='up' && $_POST['thresholdFoldChange']=='range') {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Up_Range($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($_POST['thresholdPvalue']=='down' && $_POST['thresholdFoldChange']=="up") {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Down_Up($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($_POST['thresholdPvalue']=='down' && $_POST['thresholdFoldChange']=="range") {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Down_Range($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($_POST['thresholdPvalue']=='down' && $_POST['thresholdFoldChange']=="down") {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Down_Down($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($_POST['thresholdPvalue']=='range' && $_POST['thresholdFoldChange']=="range") {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Range_Range($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} else if ($_POST['thresholdPvalue']=='range' && $_POST['thresholdFoldChange']=="up") {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Range_Up($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								}  else if ($_POST['thresholdPvalue']=='range' && $_POST['thresholdFoldChange']=="down") {
									$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_Range_Down($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],$pvalue,$foldchange);
								} 
								
									
								if ($analysisList!=NULL) {
									$rowInstance = $rowInstance."<td>".$analysisList['p_value']."</td><td>".$analysisList['foldChange']."</td>";
																
								} else {
									$rowInstance = $rowInstance."<td></td><td></td>";
								}
		
							}
						
							$tlp->assign('INSTANCE_ROW',$rowInstance);
							$tlp->parse('ROW',".rowComplex");
							$stamp_analysis = false;
							$i++;
							
						}
						if ($i<count($listGene)) {
							if (isset($_GET['order']) && isset($_GET['idanalysis']) && $_GET['order']!="" && $_GET['idanalysis']!="") {
								$tlp->assign('HREF_FOLLOWING',"<a href='showAnalysisList.php?idexperiment=".$experiment->id."&numberPvalue=".$_POST['numberPvalue']."&numberFoldChange=".$_POST['numberFoldChange']."&number=".$i."&thresholdPvalue=".$_POST['thresholdPvalue']."&thresholdFoldChange=".$_POST['thresholdFoldChange']."&order=".$_GET['order']."&idanalysis=".$_GET['idanalysis']."'>Following</a>");
							
							} else {
								$tlp->assign('HREF_FOLLOWING',"<a href='showAnalysisList.php?idexperiment=".$experiment->id."&numberPvalue=".$_POST['numberPvalue']."&numberFoldChange=".$_POST['numberFoldChange']."&number=".$i."&thresholdPvalue=".$_POST['thresholdPvalue']."&thresholdFoldChange=".$_POST['thresholdFoldChange']."'>Following</a>");
							}
						} else {
							$tlp->assign('HREF_FOLLOWING',"");
						}
						if($i>300) {
							if (isset($_GET['order']) && isset($_GET['idanalysis']) && $_GET['order']!="" && $_GET['idanalysis']!="") {
								$tlp->assign('HREF_PREVIOUS',"<a href='showAnalysisList.php?idexperiment=".$experiment->id."&numberPvalue=".$_POST['numberPvalue']."&numberFoldChange=".$_POST['numberFoldChange']."&number=".$num."&thresholdPvalue=".$_POST['thresholdPvalue']."&thresholdFoldChange=".$_POST['thresholdFoldChange']."&order=".$_GET['order']."&idanalysis=".$_GET['idanalysis']."'>Previous</a>");
							
							} else {
								$tlp->assign('HREF_PREVIOUS',"<a href='showAnalysisList.php?idexperiment=".$experiment->id."&numberPvalue=".$_POST['numberPvalue']."&numberFoldChange=".$_POST['numberFoldChange']."&number=".$num."&thresholdPvalue=".$_POST['thresholdPvalue']."&thresholdFoldChange=".$_POST['thresholdFoldChange']."'>Previous</a>");
							}
						} else {
							$tlp->assign('HREF_PREVIOUS',"");
						}
						
					} else {
						$tlp->assign('ROW_NAME_ANALYSIS',"");
						$tlp->assign('ROW_NAME_PVALUE_FOLDCHANGE',"");
						$tlp->assign('ROW',"");
					}
					
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