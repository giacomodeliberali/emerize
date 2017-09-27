<?php
        $target_dir = "../../images/productsUpload/";
        $originalName = $target_dir . basename($_FILES["immagine"]["name"]);
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $target_file = $target_dir . $codice . "." . $ext;
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