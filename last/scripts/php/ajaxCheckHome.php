<?php
	session_start();
	
	require_once("ManageDB.php");
	require_once("tools.php");
	
	$CAP=$_POST['CAP'];
	/*$Comune=$_GET['Comune'];
	$Provincia=$_GET['Provincia'];
	$Regione=$_GET['Regione'];*/
	
	$db=new ManageDB();
	$db->connect();
	
	$CAP=$db->escape($CAP);
	/*$Comune=$db->escape($Comune);
	$Provincia=$db->escape($Provincia);
	$Regione=$db->escape($Regione);*/
	
	$query='select c.Nome as Comune, p.Nome as Provincia, r.Nome as Regione from comuni c 
	inner join province p on c.Codice_provincia=p.Codice_provincia 
	inner join regioni r on p.Codice_regione=r.Codice_regione 
	where c.CAP="'.$CAP.'"';
	$result=$db->query($query);
	$row=$result->fetch_array(MYSQL_ASSOC);


		alert($CAP);
	

	$db->close();
	

	
?>