<?php

if (session_status()==PHP_SESSION_NONE) session_start();
if (empty($_SESSION['ID'])) header('Location: /e-facture/login.php');
    
    include 'Database.php';
    global $data;
    $rq = $data->prepare("SELECT * FROM facture");
    $rq->execute();

    while($ligne=$rq->fetch()){
        $rq1 = $data->prepare("SELECT * FROM designation WHERE ID_facture=:ID");     
        $rq1->execute(['ID'=> $ligne['ID'] ]);
        $conut=$rq1->rowCount();
        if ($conut==0 && $ligne['reference']!='upload'){
            $rq3 = $data->prepare("DELETE FROM facture WHERE ID=:ID");
            $rq3->execute(['ID' => $ligne['ID']]);
        }
    }
?>