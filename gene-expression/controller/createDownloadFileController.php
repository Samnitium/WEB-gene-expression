<?php
	
	include('../logic/logicAnalysisInstance.php');
	include('../logic/logicExperiment.php');
	include('../logic/logicViewPermission.php');
	
		
	session_start();
	if(isset($_SESSION['iduser'])) {
		if (isset($_GET['idexperiment']) && isset($_SESSION['analysis']) && isset($_SESSION['listGene'])) {
			$le = new logicExperiment();
			$lv = new LogicViewPermission();
			$experiment = $le->retrieveExperimentById($_GET['idexperiment']);
			$enable = $lv->verifyPermissionEnable($_SESSION['iduser'], $_GET['idexperiment']);
			$lv->db->close();
			$le->db->close();
			if ($experiment!=NULL && $enable!=NULL) {
				 $fileLocation = "../file/file_".$_GET['idexperiment'].".txt";
				 $file = fopen($fileLocation,"w");
				 $content ="";
				 $content .= "Gene\t";
				 fwrite($file,$content);
				 $content = "";
				 $analysis = unserialize($_SESSION['analysis']); 
				 $listGene = unserialize($_SESSION['listGene']);
				 foreach($analysis as $an) {
				 	$ex = explode(", ", $an);
				 	$content.= "p-value(".$ex[1].")\tfold change(".$ex[1].")\t";
					fwrite($file,$content);
					$content="";
				 }
				 $lai = new LogicAnalysisInstance();
				 foreach($listGene as $gene) {
					$content = $gene['geneSymbol']."\t";	
				 	foreach($analysis as $an) {
				 		$ex = explode(", ", $an);
				 		$analysisList = $lai->retrieveAnalysisInstanceByIdExperiment_All($_GET['idexperiment'],$ex[0],$gene['geneSymbol'],0,0);
						$content.=$analysisList['p_value_string']."\t".$analysisList['foldChange']."\t";
					}
					//fwrite($file,"\n");
					fwrite($file,PHP_EOL.$content);
				 }
				 $lai->db->close();
				 fclose($file);
				 header("Cache-Control: public");
	  			 header("Content-Description: File Transfer");
	  			 header("Content-Disposition: attachment; filename=".$fileLocation);
	  			 header("Content-Transfer-Encoding: binary");
	  //header("Content-type: application/html");
	  // Leggo il contenuto del file
	  			 readfile($fileLocation);
			}	
		}
	} else {
		header("Location: pageUnauthorized.php");
	}





?>