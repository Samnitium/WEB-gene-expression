<?php
	
	include('../logic/logicUser.php');	
	
	$lu = new LogicUser();
	$u = new User();
	$u->email = "santilli.dar@gmail.com";
	$u->password = "dario_santilli";
	$u->name = "Dario";
	$u->surname = "Santilli";
	$u->type = "superuser";
	$lu->DTO->setValue('user',$u);
	$lu->insertUser();
	$lu->db->close();
<<<<<<< HEAD
	print "FATTO ciao ciaooooo";

=======
	print "FATTO...OK";
 
>>>>>>> cd68903f766e562077294ed2180ea83c049f9593


?>