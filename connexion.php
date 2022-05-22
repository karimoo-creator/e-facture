<?php

if (session_status()==PHP_SESSION_NONE) session_start();
    if (isset($_POST['connect'])) {
        extract($_POST);
        include 'Database.php';
        global $data;
        if (!empty($email) && !empty($pass)){
            $rq1 = $data->prepare("SELECT * FROM utilisateurs WHERE email = :email");
            $rq1->execute(['email' => $email]);
            $result1= $rq1->fetch();

            if ($result1 == true) { //il exite l'email dans la table utilisateurs
                if (password_verify($pass,$result1['password'])){
                    $_SESSION['ID'] = $result1['ID'];
                    $_SESSION['acces'] =$result1['role'];
                    header('Location: /e-facture/dashboard.php');
                    exit();
                }else { $_SESSION['connect']='Mot de passe incorrect';}
            }
            if ($result1== false) { $_SESSION['connect']="Email n'existe pas"; }
        }
    }
?>
