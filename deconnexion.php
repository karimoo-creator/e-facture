<?php
    session_start();
    $_SESSION =array(); // vider tous les données stockées dans la session
    session_destroy(); 
    header("Location: /e-facture/login.php");
?>