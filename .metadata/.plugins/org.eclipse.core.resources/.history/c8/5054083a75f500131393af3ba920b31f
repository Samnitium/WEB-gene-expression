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
	print "FATTO";



?>