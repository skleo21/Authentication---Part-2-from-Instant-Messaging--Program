<?php 

 //Aumentar as informações de debug
    //mysqli_report(MYSQLI_REPORT_ALL);

    $endservidor = "localhost";
    $username = "root";
    $password = "";

    $db = new mysqli($endservidor,$username,$password,"whatstec");

    if($db -> connect_error){
        die("Connection error: ". $db->connect_error);
    }
    

?>