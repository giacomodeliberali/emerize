<?php
	require_once("config.php");
	
	class ManageDB{
		
		var $indirizzo;		// Indirizzo del database [192.168.1.252]
        var $username;		// Username per accedere al database [gest_rist]
        var $password;		// Password dello user [5bin]
        var $database;		// Nome del database [ristorante_pappa_pronta]
		
		var $msqli;         // Oggetto msqli  
		
		// Costruttore
        function ManageDB(){
            global $items_per_group, $db_name, $db_server, $db_password, $db_user;
			//$this -> indirizzo = "localhost";			
			$this -> indirizzo = $db_server;			
			$this -> username = $db_user;
			$this -> password = $db_password;
			$this -> database = $db_name;
			
		}
	

		
		// Funzione per connettersi al database
		function connect(){
			$this -> mysqli = new mysqli($this -> indirizzo, $this -> username, $this -> password, $this -> database);
			if(mysqli_connect_errno()){
                //echo "Errore numero: ".mysqli_connect_errno();
                die("Errore di connessione");
            }
            else{
            	//echo 'Connesso al database: '.$this -> indirizzo.' - '.$this -> database;
            }
		} 
		
		function error(){
			return$this->mysqli->error;
		}


		// Query per prendere tutti i clienti
		function query($query){
			
			// Faccio la query
			$result = $this->mysqli->query($query);
			return $result;
			
		}// Fine metodo 
		

		
		// Metodo per chiudere la connessione
		function close(){
			//echo "Chiudo connessione!";
			$this->mysqli -> close();
		}
		
		function affectedRows(){
			return $this->mysqli->affected_rows;
		}
		
		function escape($string){
			return htmlentities($this->mysqli->real_escape_string($string));
		}
		
	}// Fine classe ManageDB
?>