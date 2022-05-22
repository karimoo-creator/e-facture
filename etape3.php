<?php //  si l'utulisateur est non connecté alors bloquer la page de notifications 
    if (session_status()==PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['ID'])){ header('Location: /e-facture/login.php'); exit(); }
    if ($_SESSION['acces']!=3) header('Location: /e-facture/404.php');
    
    include 'Database.php';
    global $data;
    $rq = $data->prepare("SELECT * FROM utilisateurs WHERE ID = :ID");
    $rq->execute(['ID' => $_SESSION['ID']]);
    $result=$rq->fetch();
    
    $rq2 = $data->prepare("SELECT * FROM facture WHERE ID = :ID");
    $rq2->execute(['ID' => $_SESSION['IDfacture']]);
    $result2=$rq2->fetch();
    $sum=0; $s=0;

    $libellesFacture = $data->prepare("SELECT * FROM libellesFacture WHERE ID_facture = :ID");
    $libellesFacture->execute(['ID' => $_SESSION['IDfacture']]);
    $countLibelle=$libellesFacture->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Créer une facture</title>
        <link rel="icon" type="image/png" href="icon.png" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="width:16px; float:right; height:30px; margin: 0px  6px;"></i></button>
            <!--  <a class="navbar-brand ps-3" href="index.html">E-facture</a> -->
            <img src="facture.png" class="navbar-brand ps-3" alt="img-thumbnail" style="width: 200px; text-align: center; margin: 0px  -16px;" >
            
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $result['prenom'].' '.$result['nom']; ?> <i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="reglages.php">Réglages</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="deconnexion.php">Deconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <br><br>
                            <a class="nav-link " href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Tableau de bord
                            </a>
                            
                            <a class="nav-link" href="etape1.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                                Créer des factures
                            </a>

                            <a class="nav-link" href="safeFactures.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                Stocker des factures
                            </a>

                            <a class="nav-link" href="searchFactures.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Gestion de factures
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
                        <h1 class="mt-4">Création de factures: <?php echo $result2['nature'];?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item "><a class='text-success' href="index.html">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Créer des factures</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="progress" style="height: 20px">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: 100%" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">100% Etape 3</div>
                                </div>
                                <br>
                                <div class="row mb-5">
                                    <p class="col-md-3 mb-0">
                                        Facture N° : <b class='text-success'><?php echo $result2['numero']; ?></b></p>
                                    <p class="col-md-3 mb-0">
                                        Client : <b class='text-success'><?php echo $result2['client']; ?></b></p>
                                    <p class="col-md-6 mb-0">
                                        Objet : <b class='text-success'><?php echo $result2['objet']; ?></b></p>
                                </div>

                                <?php
                                    $rq3 = $data->prepare("SELECT * FROM designation WHERE ID_facture = :ID AND prix>0");
                                    $rq3->execute(['ID' => $_SESSION['IDfacture']]);
                                    $length=$rq3->rowCount();
                                    if ($length>1){
                                        $rq4 = $data->prepare("SELECT * FROM designation WHERE ID_facture = :ID AND prix=0 AND quantite=0 ");
                                        $rq4->execute(['ID' => $_SESSION['IDfacture']]);
                                        $result3=$rq4->fetch();
                                    }else $result3=$rq3->fetch();
                                ?>
                                
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Quantité</th>
                                        <th scope="col">Prix unitaire</th>
                                        <th scope="col">Prix total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($length==1){ 
                                            if ($result3['quantite']!=0 && !empty($result3['jours'])){ 

                                                $result3['jours'] = str_replace('T', '', $result3['jours']);
                                                if ($result3['jours']!=0) $s=$result3['quantite']*$result3['prix']*$result3['jours']; 
                                                $sum+=$s;
                                            }else{
                                                $s=$result3['quantite']*$result3['prix']; 
                                                $sum+=$s;
                                            }
                                        ?>
                                        <tr>
                                        <td><?php echo $result3['designation']; ?></td>
                                        <td><?php if ($result3['quantite']!=0 ) echo $result3['quantite']; ?></td>
                                        <td><?php if ($result3['prix']!=0 ) echo number_format($result3['prix'], 2, ',', ' '); ?></td>
                                        <td><?php if ($result3['quantite']!=0 ) echo number_format($s, 2, ',', ' ');?></td>
                                        </tr>

                                        <?php }else{
                                             while ($ligne = $rq3 -> fetch()) {  ?>
                                        <tr>
                                        <td><?php echo $ligne['designation']; ?></td>
                                        <td><?php echo $ligne['quantite']; ?></td>
                                        <td><?php echo $ligne['prix'].',00'; ?></td>
                                        <td><?php $s=$ligne['quantite']*$ligne['prix']; $sum+=$s; echo number_format($s, 2, ',', ' ');  ?></td>
                                        </tr>

                                        <?php }}?>

                                    </tbody>
                                </table>
                                <br>
                                <?php if($countLibelle!=0){
                                    while($libelle=$libellesFacture->fetch()){ ?>
                                        <p class="col-md-6 mb-0"> <?php echo $libelle['libelle']; ?>: <b class='text-success'> <?php echo number_format($libelle['prix'], 2, ',', ' '); if(empty($result2['devise'])) echo ' DHS'; else echo ' '.$result2['devise'];?> </b></p>
                                <?php }}?>

                                <p class="col-md-3 mb-0">
                                    TOTAL (DH,TTC): <b class='text-success'> <?php echo number_format($sum, 2, ',', ' '); if(empty($result2['devise'])) echo ' DHS'; else echo ' '.$result2['devise'];?></b></p>
                                
                                    <?php if(!empty($result2['observations'])) {?>
                                <p class=" mb-0">
                                    Observations : <b class='text-success'> <?php echo $result2['observations']; ?> </b></p>
                                <?php }
                                    $rq=$data->prepare('SELECT * FROM banque WHERE ID=:ID');
                                    $rq->execute([ 'ID' => $result2['ID_banque'] ]);
                                    $bank=$rq->fetch();
                                ?>
                                <p class=" mb-0">
                                    Paiement : <b class='text-success'> Virement bancaire N° <?php echo $bank['numero'].' | '.$bank['agence']; ?></b>
                                </p>

                                <p class=" mb-0">
                                    Transfert : <b class='text-success'> <?php echo $bank['nature']; ?></b>
                                </p>
                                
                            </div>
                        </div>
                        <div class="modal fade" id="supprimer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h5 class="modal-title text-white" id="staticBackdropLabel"><i class="fa fa-exclamation-triangle"></i> Attention</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form class="needs-validation" novalidate action='' method='post'>
                                        <div class="modal-body">
                                            <b>Voulez-vous vraiment supprimer la facture <?php echo $result2['numero'];?>? </b>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-block" data-bs-dismiss="modal"><i class="fa fa-times"></i> NON</button>
                                            <button type="submit" name='delete' class="btn btn-success btn-block"><i class="fa fa-check"></i>  OUI</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" class="btn btn-primary" onclick="window.location.href='/e-facture/dashboard.php'"><i class="fa fa-save"></i> enregistrer</button>
                        <button type="button" class="btn btn-warning" onclick="window.location.href='/e-facture/modifierFacture.php?id='+<?php echo $_SESSION['IDfacture'];?>"><i class="fa fa-edit"></i> modifier</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#supprimer"><i class="fa fa-trash-alt"></i> supprimer</button>
                        <button type="button" class="btn btn-info" onclick="window.location.href='/e-facture/print.php?id='+<?php echo $_SESSION['IDfacture'];?>"><i class="fa fa-print"></i> imprimer</button>
                        
                    </div>
                </main>
                
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <a class="text-muted" href="guide.php">Guide E-facture</a>
                            <div>
                                <a class="text-success" href="https://www.amee.ma/fr/home">AMEE</a> 
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>

<?php

if (isset($_POST['delete'])){
    $rq3 = $data->prepare("DELETE FROM facture WHERE ID=:ID");
    $rq3->execute(['ID' => $_SESSION['IDfacture']]);

    $rq4 = $data->prepare("DELETE FROM designation WHERE ID_facture=:ID");
    $rq4->execute(['ID' => $_SESSION['IDfacture']]);

    ?><script> 
        window.location.assign("/e-facture/dashboard.php"); 
    </script> <?php
}
if ($sum !=0){
    $rq2 = $data->prepare("UPDATE facture SET prix_total = :prix WHERE ID=:ID");
    $rq2->execute(['ID' => $_SESSION['IDfacture'], 'prix' => $sum]);
}
?>