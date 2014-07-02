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
				
				
				$lai = new LogicAnalysisInstance();
				$analysisList = $lai->retrieveAnalysisInstanceByIdExperimentThreshold($_GET['idexperiment'],$pvalue,$foldchange); 
				$lai->db->close();
				
?>
				
			
			


<!DOCTYPE html>
<html>
	<head>
		<title>List Analysis</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>	
		<link href="http://localhost/workspace/WEB-gene-expression/gene-expression/bootstrap/CSS/bootstrap.min.css" rel="stylesheet" media="screen"/>
		<link href="http://localhost/workspace/WEB-gene-expression/gene-expression/bootstrap/CSS/bootstrap.css" rel="stylesheet" media="screen"/>
		<script src="http://localhost/workspace/WEB-gene-expression/gene-expression/bootstrap/js/bootstrap.js"></script>
		<script src="http://localhost/workspace/WEB-gene-expression/gene-expression/bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div style="text-align:right; margin-right:20px; margin-top:2px;"> <a href="profileUserController.php"><font size="3dp">profile</font></a></div>
		<div style="text-align:right; margin-right:20px; margin-top:2px;"> <a href="logoutController.php"><font size="3dp">logout</font></a></div>
		<div style="text-align:right; margin-right:20px; margin-top:2px;"> <a href="<?php if ($_SESSION['type']=='superuser') {
																						print "superUserChoiceController.php";
																					} else print "userChoiceController.php"; 
																					?>"><font size="3dp">home</font></a></div>
																					
											
		<div align="center">
		<nav class="navbar navbar-inverse" style="background-color:#01DF74; width:900px;" >
  			<div class="page-header">
  				<h1>Experiment analysis list</h1>
			</div>
		</nav>
		<div class="panel panel-default">
  			<div class="panel-heading"> <?php $experiment->name ?> </div>
 				 <table class="table">
   					<tr><th>Gene symbol</th><th>P value</th><th>Fold change</th><th>Name</th><th>Date</th></tr>
					<?php	if (isset($analysisList) && count($analysisList)!=0) {
								foreach ($analysisList as $an) {	
								  print "<tr><td><a href='showGene.php?gene_symbol=".$an['geneSymbol']."'>".$an['geneSymbol']."</a></td>
								         <td>".$an['p_value']." </td> <td>".$an['foldChange']."</td><td>".$an['name']."</td><td>".$an['date']."</td></tr>";
					}
				} ?>
  				</table>
		</div>
		</div>
		<div id ="footer" style="margin-top:10px;" align="center" >
				<img src="http://localhost/workspace/WEB-gene-expression/gene-expression/bootstrap/img/footer.jpg">
		</div>
		

	</body>
</html>

<?php
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


