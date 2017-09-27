<?php
	session_start();
	
	require_once("ManageDB.php");

	$db=new ManageDB();
            $db->connect();
                $query='select * from areautenti;';
                $result=$db->query($query);
                while($row=$result->fetch_array(MYSQL_ASSOC)) {
                	echo '<div class="media msg "><div class="media-body"><small class="pull-right time"><i class="fa fa-clock-o"></i>'.$row['Data'].'</small><h5 class="media-heading">'.$row['Mittente'].'</h5><small class="col-lg-10">'.$row['Messaggio'].'</small></div></div>	';
                }

            $db->close();

?>