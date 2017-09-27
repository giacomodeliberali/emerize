<?php
if(!isset($_SERVER['DOCUMENT_ROOT'])){
 if(isset($_SERVER['SCRIPT_FILENAME'])){
	$_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0-strlen($_SERVER['PHP_SELF'])));
 };
};

echo $_SERVER['DOCUMENT_ROOT'] . "<br>";


if(!isset($_SERVER['DOCUMENT_ROOT'])){
 if(isset($_SERVER['PATH_TRANSLATED'])){
	$_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0-strlen($_SERVER['PHP_SELF'])));
 };
};

$PercorsoDominio = $_SERVER['DOCUMENT_ROOT'];
//echo "<br>".$PercorsoDominio;
$public = "/tesina/last/images/productsUpload/";
echo $PercorsoDominio.$public . "<br>";
if(is_dir($PercorsoDominio.$public))
{

   echo "<font color=green>Check cartella OK.</font><br>";

}
else
{

   echo "<font color=red>ATTENZIONE LA CARTELLA DI DESTINAZIONE NON ESISTE. FARE RIFERIMENTO ALLA GUIDA, CREARE LA CARTELLA. UPLOAD NON RIUSCITO</font><br>";
exit;
}
?>