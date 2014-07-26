<?php
	
		
	session_start();
	if(isset($_SESSION['iduser'])) {
		$fileLocation = "../../documentation/usageCase.pdf";
		
		header("Cache-Control: public");
	  	header("Content-Description: File Transfer");
	  	header("Content-Disposition: attachment; filename=".$fileLocation);
	  	header("Content-Transfer-Encoding: binary");
		//header("Content-type: application/pdf");
	  // Leggo il contenuto del file
	  	readfile($fileLocation);	
		
	} else {
		header("Location: pageUnauthorized.php");
	}





?>