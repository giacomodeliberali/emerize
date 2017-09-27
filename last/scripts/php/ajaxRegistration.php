<?php
	
	session_start();
	
	require_once("ManageDB.php");
	require_once("tools.php");


	$db = new ManageDB();
	$db->connect();

	$comune = $db->escape($_POST['comune']);
	$provincia = $db->escape($_POST['provincia']);
	$regione = $db->escape($_POST['regione']);
	$codiceFiscale = $db->escape($_POST['codiceFiscale']);
	$nome = $db->escape($_POST['nome']);
	$cognome = $db->escape($_POST['cognome']);
	$dataNascita = $db->escape($_POST['dataNascita']);
	$telefono = $db->escape($_POST['telefono']);
	$indirizzo = $db->escape($_POST['indirizzo']);
	$type = $db->escape($_POST['type']);
	$username = $db->escape($_POST['username']);
	$password = $db->escape($_POST['password']);
	$immagine = $_POST['immagine'];
	
	$comuneNegozio = $db->escape($_POST['comuneNegozio']);
	$provinciaNegozio = $db->escape($_POST['provinciaNegozio']);
	$regioneNegozio = $db->escape($_POST['regioneNegozio']);
	$partitaIva = $db->escape($_POST['partitaIva']);
	$nomeNegoizo = $db->escape($_POST['nomeNegoizo']);
	$tipologia = $db->escape($_POST['tipologia']);
	$telefonoNegozio = $db->escape($_POST['telefonoNegozio']);
	$indirizzoNegozio = $db->escape($_POST['indirizzoNegozio']);
	
	$query = "SELECT CAP, Nome from comuni where Codice_comune='$comune'";
	$result = $db->query($query);
	$row = $result->fetch_array(MYSQL_NUM);
	$cap = $row[0];
	$comune = $row[1];
	
	$query = "SELECT Nome from province where Codice_provincia='$provincia'";
	$result = $db->query($query);
	$row = $result->fetch_array(MYSQL_NUM);
	$provincia = $row[0];
	
	$query = "SELECT Nome from regioni where Codice_regione='$regione'";
	$result = $db->query($query);
	$row = $result->fetch_array(MYSQL_NUM);
	$regione = $row[0];
	
	$target_dir = $_SERVER["DOCUMENT_ROOT"] . "/public/images/usersUpload/";
    $originalName = $target_dir . basename($_FILES["immagine"]["name"]);

    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $target_file = $target_dir . $codiceFiscale . "." . $ext;
	
	$imagePath = (!empty($ext) ? $codiceFiscale.".".$ext : 'default.png');
	
	$query = "
		INSERT
			INTO utenti values(
				'$codiceFiscale',
				'$nome',
				'$cognome',
				'$dataNascita',
				'$telefono',
				'$indirizzo',
				'$comune',
				'$cap',
				'$provincia',
				'$regione',
				'$type',
				'$username',
				MD5('$password'),
				'$imagePath',
				'0'
			)";

	$userInert = $db->query($query);
	
	if($userInert){
			$type = $_POST['type'];
			if(substr($type, 0, 1) == "1"){
				$query = "SELECT CAP, Nome from comuni where Codice_comune='$comuneNegozio'";
				$result = $db->query($query);
				$row = $result->fetch_array(MYSQL_NUM);
				$capNegozio = $row[0];
				$comuneNegozio = $row[1];
				
				$query = "SELECT Nome from province where Codice_provincia='$provinciaNegozio'";
				$result = $db->query($query);
				$row = $result->fetch_array(MYSQL_NUM);
				$provinciaNegozio = $row[0];
				
				$query = "SELECT Nome from regioni where Codice_regione='$regioneNegozio'";
				$result = $db->query($query);
				$row = $result->fetch_array(MYSQL_NUM);
				$regioneNegozio = $row[0];
				$query = "INSERT INTO negozi values ('$partitaIva', '$codiceFiscale', '$nomeNegoizo', $tipologia, '$telefonoNegozio', '$indirizzoNegozio', '$comuneNegozio', '$capNegozio', '$provinciaNegozio', '$regioneNegozio')";
				
				
				$negozioInsert = $db->query($query);
				if($userInert && $negozioInsert){
					echo "success all";
					//sendMail($_POST['partitaIva']);
				}else{
					echo "fail market";
				}
			}else{
				echo "success user";
			}
		
			
	}else{
		echo "failure all";
	}
	$db->close();
	


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
	
	

	
    

?>