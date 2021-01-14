<?php 
	if (isset($_REQUEST['license']) && (isset($_REQUEST['ip']))) {
		require_once "dbconnect.php";
		$connection = @new mysqli($host, $user, $password, $db_name);
		if ($connection->connect_errno!=0)
		{
			echo '[{"Valid": false}]';
		}else{
			$licencja = $_REQUEST['license'];
			$ip = $_REQUEST['ip'];
			$licencja = htmlentities($licencja, ENT_QUOTES, "UTF-8");
			$ip = htmlentities($ip, ENT_QUOTES, "UTF-8");
			$sql = "SELECT * from licenses WHERE license='$licencja'";
			if  ($resultat = @$connection->query(sprintf("SELECT * from licenses WHERE license='%s'",
			mysqli_real_escape_string($connection,$licencja))))
			{
				$records  = $resultat->num_rows;
				if($records==1){
					$verse = $resultat->fetch_assoc();
					$myip = $verse['ip'];
					#echo $myip;
					if($myip != ""){
						if($myip == $ip && $verse['valid'] == "1"){
							echo '[{"Valid": true}]';
						}else {
							echo '[{"Valid": false-1}]';
						}
					}else {
						if($verse['valid']==1){
							echo '[{"Valid": true}]';
						}
					}
					$resultat->free();
				}else {
					echo '[{"Valid": false}]';
				}
			}else {
				echo '[{"Valid": false}]';
			}
			$connection->close();
		}
	} else { 
		echo '[{"Valid": false}]';
		exit();
}
?>