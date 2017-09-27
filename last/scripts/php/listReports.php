<?php
	
	session_start();
	
		if(isset($_SESSION['Username']) && (isset($_SESSION['tipologiaUtente']) && $_SESSION['tipologiaUtente']) == "000"){
				require_once("ManageDB.php");
				require_once("MessageHandler.php");
				
				$db = new ManageDB();
				$db->connect();
				
				$query = "
					SELECT
						s.Codice, 
						s.Oggetto,
						st.Nome,
						s.Data,
						u.Username
					FROM
						segnalazioni s
					INNER JOIN 
						tipologiesegnalazioni st
					ON
						st.Codice_segnalazione=s.Tipologia
					INNER JOIN 
						utenti u 
					ON 
						u.Codice_fiscale=s.Utente
				";
				$result = $db->query($query);
				$users = array();
				while($row = $result->fetch_array(MYSQLI_ASSOC)){

					$singleRow["Codice"] = $row["Codice"];	
					$singleRow["Oggetto"] = $row["Oggetto"];		
				    $singleRow["Nome"] = $row["Nome"];
					$singleRow["Data"] = $row["Data"];
					$singleRow["Username"] = $row["Username"];

					$reports[] = $singleRow;
				}
				
				if(count($reports)>0){
					echo json_encode($reports);	
				}else{
					echo "[]";
				}
				
				
				$db->close();
				
		}else{
			header("Location: /index.php");
		}

	
	

?>