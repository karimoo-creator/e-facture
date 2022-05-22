

<?php

if (isset($_POST['envoyer'])) {

    extract($_POST);
    include 'Database.php';
    global $data;

    if (!empty($email)){
        $rq = $data->prepare("SELECT * FROM etudiant WHERE email = :email");
        $rq->execute(['email' => $email]);
        $result= $rq->fetch();
        
        if ($result == true){

            function genererChaineAleatoire($longueur = 8){ //generer un string aleatoire 
                $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $longueurMax = strlen($caracteres);
                $chaineAleatoire = '';
                for ($i = 0; $i < $longueur; $i++)  $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
                return $chaineAleatoire;
            }
            $word= genererChaineAleatoire();

            $header='MINE-Version: 1.0\r\n';
            $header.='From: "E-facture" <mycourses.contacts@gmail.com>';
            $header.='Content-Type : text/html; charset="uft-8"'.'\n';
            $header.='Content-Transfer-Encoding: 8bit';

            $message='
            Bonjour '.  $result['prenom'].' '.$result['nom'].'
            Nouveau mot de passe : '. $word.' 
            Pour changer le mot de passe, veuillez accéder à votre espace profil 

            Équipe My.Courses 
            ';

            mail('kmouhssiny@gmail.com','Réinitialisation du mot de passe',$message,$header);

            $configuration = ['cost' => 12];
            $hachpass = password_hash($word, PASSWORD_BCRYPT, $configuration);
            if (!password_verify($word,$hachpass)) {echo 'cryptage de mot de passe échoué';  exit(); }

            $rq1 = $data->prepare("UPDATE etudiant  SET password=:pass WHERE ID=:ID");
            $rq1->execute([
                'pass' => $hachpass , 
                'ID' => $result['ID']
            ]);
            echo '<script> alert("My.Courses :: Un email vous a été envoyé avec votre nouveau mot de passe"); </script>';    
        } else echo '<script> alert("My.Courses :: cet email n existe pas dans notre base de données"); </script>';
    }
}

?>