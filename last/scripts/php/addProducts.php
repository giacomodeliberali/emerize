<?php
	session_start();
	
	require_once("ManageDB.php");
	require_once("MessageHandler.php");

	$db = new ManageDB();
	$db->connect();
	
    $nome=$db->escape($_POST['nome']);
    $marca=$db->escape($_POST['marca']);
    $descrizione=$db->escape($_POST['descrizione']);
    $tipologia=$_POST['tipologia'];
    $sottotipologia=$_POST['sottotipologia'];
    $peso=$_POST['peso'];
    $immagine=$_POST['immagine'];
    if(empty($immagine)){
        $immagine = "default.png";
    }

    $query="select max(Codice_prodotto) as codice from prodotti where Nome like '". substr($nome, 0, 4) . "%';";

   
    
    $result=$db->query($query);
    $row=$result->fetch_array(MYSQLI_ASSOC);
    $cont=((int)substr($row['codice'], 5))+1;
    
    
    if($cont>0 && $cont<10){
        $cont = "_000" . $cont;
    }else if($cont>9 && $cont<100){
        $cont = "_00" . $cont;
    }else if($cont>99 && $cont<1000){
        $cont = "_0" . $cont;
    }
    $codice = strtoupper(substr($nome, 0, 4)) . $cont;
    
	
    $target_dir = $_SERVER["DOCUMENT_ROOT"] . "/public/images/productsUpload/";
	
    $originalName = $target_dir . basename($_FILES["immagine"]["name"]);
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $target_file = $target_dir . $codice . "." . $ext;
	$imageURL = $codice . "." . $ext;
    //echo $codice;
    
		$query = "
			INSERT INTO prodotti VALUES (
				'$codice',
				'$nome',
				'$marca',
				'$descrizione',
				$tipologia,
				$sottotipologia,
				'$imageURL',
				$peso
			);
		";
		//echo $query;

		$result = $db->query($query);
	
	//echo $query;
	
	
	if($db->affectedRows() == "1"){
		        
       
       
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST["immagine"])) {
            $check = getimagesize($_FILES["immagine"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $text = "Il file non &egrave un\'immagine.";
                $uploadOk = 0;
            }
        }
        // Check file size
        if ($_FILES["immagine"]["size"] > 5000000) { //5mb
            $text = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $text = "I formati supportati sono JPG, JPEG, PNG & GIF.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $text = "Errore interno, file non caricato.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["immagine"]["tmp_name"], $target_file)) {
                $text = "Il file &egrave stato caricato.";
            } else {
                $text = "Errore nel caricamento del file.";
            }
        }
        
        $msg = new MessageHandler("Prodotto Aggiunto.", "success", $text);
	}else{
		//$errors = $db->error();
		$errors = $query;
		$msg = new MessageHandler("Prodotto non aggiunto!", "error", "$errors");
	}
	
	
	
	$db->close();
    

    
    echo $msg->toJSON();
	
?>