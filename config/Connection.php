<?php 
	 $conn = new mysqli("localhost","root","","user");

    if($conn->connect_errno){
        die("Connection Failed".$conn->connect_errno);
    }
 ?>