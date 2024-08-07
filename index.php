<?php
	
	if(!isset($_SESSION['username'])){
		header ('Location: page/login/login.php');
	}
?>