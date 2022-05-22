<?php //  si l'utulisateur est non connecté alors bloquer la page de notifications 
    if (session_status()==PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['ID'])){ header('Location: /e-facture/login.php'); exit(); }
    
    include 'Database.php';
    global $data;
    $rq = $data->prepare("SELECT * FROM utilisateurs WHERE ID = :ID");
    $rq->execute(['ID' => $_SESSION['ID']]);
    $result=$rq->fetch();

    if ($result['role']!='administrateur') header('Location: /e-facture/404.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>Réglages</title>
        <link rel="icon" type="image/png" href="icon.png" />
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        
	    <link rel="stylesheet" href="css/bootstrap4-toggle.css">
	    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

        
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="width:16px; float:right; height:30px; margin: 0px  6px;"></i></button>
            <img src="facture.png" class="navbar-brand ps-3" alt="img-thumbnail" style="max-height: 190px; text-align: center" >
            
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $result['prenom'].' '.$result['nom'];?> <i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu  dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item " href="reglages.php">Réglages</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item " href="login.html">Deconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <br>
                            <a class="nav-link text-success " href="dashboard.php">
                                <div class="sb-nav-link-icon text-success"><i class="fas fa-tachometer-alt"></i></div>
                                Tableau de bord
                            </a>
                            
                            <a class="nav-link text-success" href="factures.php">
                                <div class="sb-nav-link-icon text-success"><i class="fas fa-edit"></i></div>
                                Créer des factures
                            </a>

                            <a class="nav-link text-success" href="safeFactures.php">
                                <div class="sb-nav-link-icon text-success"><i class="fas fa-cloud-upload-alt"></i></div>
                                Stocker des factures
                            </a>

                            <a class="nav-link text-success" href="searchFactures.php">
                                <div class="sb-nav-link-icon text-success"><i class="fas fa-columns"></i></div>
                                Gestion de factures
                            </a>
                            
                            
                            <div class="sb-sidenav-menu-heading">Divers</div>
                            <a class="nav-link text-success" href="users.php">
                                <div class="sb-nav-link-icon text-success"><i class="fas fa-users"></i></div>
                                Gestion des rôles
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Agence marocaine pour l'éfficacité énergetique</div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"><i class="fa fa-users"></i> Gestion des rôles</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item "><a class='text-success' href="reglages.php"> Réglages</a></li>
                            <li class="breadcrumb-item active">Gestion des rôles</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header bg-success">
                                <i class="fas fa-user-plus me-1 text-white"></i>
                                <b class='text-white'>Ajouter un utilisateur</b>
                                 
                            </div>
                            <div class="card-body">
                                <form class="needs-validation" novalidate  action='' method='POST'>
                                    <div class="form-row">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input class="form-control " name="nom" type="text" placeholder="." required/>
                                                    <label for="nom">Nom</label>
                                                        <div class="invalid-feedback">Champs obligatoire</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="prenom" type="text" placeholder="." required/>
                                                        <label for="prenom">Prénom </label>
                                                        <div class="invalid-feedback">Champs obligatoire</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control " name="cin" type="text" placeholder="." required>
                                                        <label for="cin">Numéro de la CNIE</label>
                                                        <div class="invalid-feedback">Champs obligatoire</div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row ">
                                                <div class="col-md-4">
                                                    <div class="form-floating mb-2 ">
                                                        <input class="form-control " name="email" type="email" placeholder="." required>
                                                        <label for="email">Gmail</label>
                                                        <div class="invalid-feedback">Champs obligatoire</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                    <input class="form-control" name="fonction" type="text" placeholder="." required/>
                                                    <label for="fonction">Fonction</label>
                                                    <div class="invalid-feedback">Champs obligatoire</div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-2">
                                                        <select class="form-select shadow-success" name="ville" placeholder="." required>
                                                            <option value=''>....</option>
                                                            <option value='Marrakech'>Direction régionale - Marrakech</option>
                                                            <option value='Rabat'>Siège - Rabat</option>
                                                        </select>
                                                        <label for="ville" >Direction</label>
                                                        <div class="invalid-feedback">Vous devez choisir une réponse</div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-6">
                                                    <div class="card mb-1 card-body">    
                                                        <div class="row mb-0">
                                                            <div class="col-md-4">  
                                                                <b class="mb-1 " > Rôle plateforme </b>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input " name="role" type="radio" value="administrateur" required/>
                                                                    <label class="form-check-label" for="role">Administrateur</label>
                                                                    <div class="invalid-feedback">Vous devez choisir une réponse</div>
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="form-check  col-md-4 ">
                                                                <input class="form-check-input " name="role" type='radio' value="contributeur" required/>
                                                                <label class="form-check-label" for="role">Contributeur</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4"></div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-info" style="width:140px; float:left; height:50px; margin: 0px  48px;" type='submit'name='add'><i class="fa fa-user-plus"></i> <b> Ajouter</b></button>
                                                </div>
                                            </div> 
                                            <?php
                                                if (isset($_POST['add'])) {
                                                    extract($_POST);
                                                    global $data;
                                                    
                                                    if (!empty($nom) && !empty($prenom) && !empty($cin) && !empty($email) && !empty($fonction) && !empty($ville) && !empty($role)){
                                                        //elimination des espaces
                                                        $cin = str_replace(' ', '', $cin);
                                                        $cin=strtoupper($cin);

                                                        $rq2 = $data->prepare("SELECT cin FROM utilisateurs WHERE cin = :cin");
                                                        $rq2->execute(['cin' => $cin]);
                                                        $result2= $rq2->rowCount();

                                                        $rq3 = $data->prepare("SELECT email FROM utilisateurs WHERE email = :email");
                                                        $rq3->execute(['email' => $email]);
                                                        $result3= $rq3->rowCount();

                                                        if ($result2==0 && $result3==0){

                                                            function genererChaineAleatoire($longueur = 8){ //generer un string aléatoire 
                                                                $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                                                $longueurMax = strlen($caracteres);
                                                                $chaineAleatoire = '';
                                                                for ($i = 0; $i < $longueur; $i++)  $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
                                                                return $chaineAleatoire;
                                                            }
                                                            $word= genererChaineAleatoire();

                                                            $configuration = ['cost' => 12];
                                                            $hachpass = password_hash($word, PASSWORD_BCRYPT, $configuration);
                                                            if (!password_verify($word,$hachpass)) { $error='cryptage de mot de passe échoué'; exit();}
                                                            
                                                            $nom=strtoupper($nom);
                                                            $prenom=strtoupper($prenom);
                                                            global $data;
                                                            $req= $data->prepare('INSERT INTO utilisateurs(nom,prenom,cin,email,fonction,direction,role,password) VALUES(:nom,:prenom,:cin,:email,:fonction,:direction,:role,:password)');
                                                            $req->execute([
                                                                'nom'=>$nom,
                                                                'prenom'=>$prenom,
                                                                'cin'=>$cin,
                                                                'email'=>$email,
                                                                'fonction' => $fonction,
                                                                'direction'=>$ville,
                                                                'password'=>$hachpass,
                                                                'role'=>$role
                                                            ]);   
                                                            
                                                            $header='MINE-Version: 1.0\n';
                                                            $header.='From: "E-facture" <efacture.contact@gmail.com>';
                                                            $header.='Content-Type : text/html; charset="uft-8"'.'\n';
                                                            $header.='Content-Transfer-Encoding: 8bit';

                                                            $message="
                                                            Bonjour ".$prenom." ".$nom."
                                                            Soyez le bienvenu dans la plateforme E-facture de l'agence marocaine pour l'éfficacité énergetique
                                                            Pour se connecter, veuillez saisir les informations suivantes dans l'interface de connexion.
                                                            Adresse électronique : ".$email."  
                                                            Nouveau mot de passe :  ".$word." 

                                                            Vous êtes maintenant un ". $role ."
                                                            Pour changer le mot de passe, veuillez accéder à votre espace réglages > changer mot de passe. 

                                                            Équipe E-facture
                                                            ";

                                                            mail($email,'Création du compte E-facture',$message,$header);

                                                        }else if($result3!=0) $error.=' Cette adresse email existe déjà.';  else if ($result2!=0) $error.=' Ce numéro CNIE existe déjà.';

                                                    if(!empty($error)){
                                            ?>       
                                            <div class='col-md-6'>
                                                <div class="h-50 card  alert alert-danger" role="alert" style='margin: 0px  0px;'>
                                                    <div class="row  ">
                                                        <div class='col-md-11' style='margin: -12px  0px;'><i class="fa fa-exclamation-triangle "></i> <b><?php echo $error;?></b></div>
                                                        <div class='col-md-1' style='margin: -12px -6px;'>
                                                            <button type="button" class="btn-close btn-danger" data-bs-dismiss="alert" aria-label="Close" ></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                            <?php  }else{  ?>
                                            <div class='col-md-6'>
                                                <div class="h-50 card  alert alert-info" role="alert" style='margin: 0px  0px;'>
                                                    <div class="row  ">
                                                        <div class='col-md-11' style='margin: -12px  0px;'><i class="fa fa-exclamation-triangle "></i> <b>Le nouveau utilisateur est ajouté avec succès.</b></div>
                                                        <div class='col-md-1' style='margin: -12px -6px;'>
                                                            <button type="button" class="btn-close btn-info" data-bs-dismiss="alert" aria-label="Close" ></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            <?php  }}} ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-success">
                            <form method="post" action=''>
                                <div class="row ">
                                    <div class='col-md-9'> <i class="fas fa-table me-1 text-white"></i> <b class='text-white'>Utilisateurs de la plateforme </b></div>
                                    <div class='col-md-2'  >
                                        <div style="width:260px; float:left; height:16px; margin: -6px  -26px;" >
                                            <button  class="btn btn-success btn-block" name='change' type='submit'><i class="fa fa-save"></i>  Enregistrer les modifications</button>
                                        </div>
                                    </div>
                                    
                                    <div class='col-md-1'  >
                                        <div style=" float:left; margin: -6px  36px;" >
                                            <button style="width:40px; height:px;" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editerRole"><i class="fa fa-question-circle fa-lg" style="width:22px; float:center; height:22px; margin: 0px  -4px;" ></i></button>
                                        </div>
                                    </div>
                                </div>
                                 
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered border-dark">
                                    <thead>
                                        <tr>
                                            <th  class='bg-dark text-white ' style='text-align:center' width="5px">ID</th>
                                            <th class='bg-dark text-white ' style='text-align:center' width="230px">Nom et Prénom</th>
                                            <th class='bg-dark text-white ' style='text-align:center'width="200px">Fonction</th>
                                            <th class='bg-dark text-white ' style='text-align:center' width="150px">Date inscription</th>
                                            <th class='bg-dark text-white' style='text-align:center' width="80px">Gmail</th>
                                            <th  class='bg-dark text-white ' style='text-align:center' width="50px">Rôle</th>
                                            <th class='bg-dark text-white ' style='text-align:center' width="2px"><i class="fa fa-user-shield fa-lg" ></i></th>
                                            <th class='bg-dark text-white ' style='text-align:center' width="2px"><i class="fa fa-trash-alt fa-lg" ></i></th>

                                        </tr>
                                    </thead>

                                    

                                    <tbody>

                                        <?php 
                                        $rq = $data->prepare("SELECT * FROM utilisateurs");
                                        $rq->execute();

                                        while ($ligne = $rq -> fetch()) { ?>
                                        <tr>
                                            <td><?php echo $ligne['ID'];?></td>
                                            <td><?php echo $ligne['prenom'].' '.$ligne['nom'];?></td>
                                            <td><?php echo $ligne['fonction'];?></td>
                                            <td style='text-align:center' ><?php echo date('d/m/Y', strtotime($ligne['date_inscription'])); ?></td>
                                            <td><?php echo $ligne['email']; ?></td>
                                            <td><?php echo $ligne['role']; ?></td>

                                            <td>
                                                <div class="form-check" >
                                                        <input class="form-check-input" name="newRole[]" value='<?php echo $ligne['ID']; ?>' type="checkbox" style="width:20px; height:20px; margin: 5px 24px;"/>
                                                </div>                                            
                                            </td>

                                            <td>
                                                <div class="form-check" >
                                                    <?php if ( $ligne['nom']!=$result['nom'] && $ligne['prenom']!=$result['prenom'] ){?>
                                                    <input class="form-check-input" name="delete[]" value='<?php echo $ligne['ID']; ?>' type="checkbox" style="width:20px; height:20px; margin: 5px 24px;"/>
                                                    <?php }?>
                                                </div>                                            
                                            </td>
                                        </tr>
                                        <?php } ?>
 
                                    </tbody>
                                    </form>

                                    <?php

                                    $rq = $data->prepare("SELECT * FROM utilisateurs");
                                    $rq->execute();
                                    $len=$rq->rowcount();

                                    if (isset($_POST['change'])) {

                                        extract($_POST);
                                        global $data;
                                        $i=0;
                                        
                                        for($i=0;$i<$len;$i++) {

                                            if(!empty($newRole[$i])) { //role administrateur
                                                $rq = $data->prepare("SELECT * FROM utilisateurs WHERE ID=:ID");
                                                $rq->execute(['ID'=> $newRole[$i]]);
                                                $content=$rq->fetch();

                                                if ($content['role']== 'administrateur'){
                                                $rq2 = $data->prepare("UPDATE utilisateurs  SET role=:role WHERE ID=:ID");
                                                $rq2->execute(['role' => 'contributeur', 'ID'=> $newRole[$i]]);

                                                }else {
                                                    $rq2 = $data->prepare("UPDATE utilisateurs  SET role=:role WHERE ID=:ID");
                                                    $rq2->execute(['role' => 'administrateur', 'ID'=> $newRole[$i]]);
                                                }
                                            }           

                                            if (!empty($delete[$i]) ) {

                                                $rq3 = $data->prepare("DELETE FROM utilisateurs WHERE ID=:ID");
                                                $rq3->execute(['ID' => $delete[$i] ]);
                                            }
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>

                        <div class="modal fade" id="editerRole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-success">
                                        <h5 class="modal-title text-white" id="staticBackdropLabel">Rôle en E-facture</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        La plateforme permet à chaque utilisateur selon son rôle d'effectuer les opérations suivantes : 
                                        <br>
                                        <table class="table table-bordered border-black">
                                            <tbody>
                                                <tr>
                                                    <td><b>Administrateur</b></td>
                                                    <td>Créer,modifier, importer ou supprimer les factures</td> 
                                                </tr>
                                                <tr>
                                                    <td><b>Contributeur</b></td>
                                                    <td>Visualiser et imprimer les factures </td> 
                                                </tr>

                                            </tbody> 
                                        </table>
                                        
                                        <hr>
                                        Vous pouvez changer le rôle de l'utilisateur selon les étapes suivantes : <br>
                                        <b>1 - Pointer dans la colonne <i class="fa fa-user-shield"> </i> pour changer le rôle de l'utulisateur de la même ligne </b><br>
                                        <b> 2- Enregistrer le changement en cliquant sur <i class="fa fa-save"> </i> enregistrer les modifications </b>
                                        <hr>
                                        Vous pouvez supprimer un utilisateur selon les étapes suivantes : <br>
                                        <b>1 - Pointer dans la colonne <i class="fa fa-trash"> </i> pour l'utulisateur de la même ligne </b><br>
                                        <b> 2- Enregistrer le changement en cliquant sur <i class="fa fa-save"> </i> enregistrer les modifications </b>
                                    </div>
                                </div>
                            </div>
                        </div>
                </main>

                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted"> <a class="text-dark" href="guide.php">Guide E-facture</a></div>
                            <div>
                                <a class="text-success" href="https://www.amee.ma/fr/home">AMEE</a>    
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script>
            (function() {
              'use strict';
              window.addEventListener('load', function() {
                let forms = document.getElementsByClassName('needs-validation');
                let validation = Array.prototype.filter.call(forms, function(form) {
                  form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                      event.preventDefault();
                      event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                  }, false);
                });
              }, false);
            })();
        </script>
    </body>

    <script>
        function suite (){
            formulaire.suivre.click();
        }
    </script>
</html>


