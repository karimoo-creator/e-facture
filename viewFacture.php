<?php //  si l'utulisateur est non connecté alors bloquer la page de notifications 
    if (session_status()==PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['ID'])) header('Location: /e-facture/login.php');
    
    include 'Database.php';
    global $data;
    $rq = $data->prepare("SELECT * FROM utilisateurs WHERE ID = :ID");
    $rq->execute(['ID' => $_SESSION['ID']]);
    $result=$rq->fetch();

    if (isset($_GET['id']) && $_GET['id']>0){ 

        $id= intval($_GET['id']); // securité : empecher l'utulisateur a editer du texte en url

        $rq2 = $data->prepare("SELECT * FROM facture WHERE ID = :ID");
        $rq2->execute(['ID' => $id]);
        $result2=$rq2->fetch(); 

        $rq3 = $data->prepare("SELECT * FROM designation WHERE ID_facture = :ID ");
        $rq3->execute(['ID' => $id]);
        $length=$rq3->rowCount();
        if ($length>1){
            $rq4 = $data->prepare("SELECT * FROM designation WHERE ID_facture =:ID ");
            $rq4->execute(['ID' => $id]);
            $result3=$rq4->fetch();
        }else $result3=$rq3->fetch();

        $libellesFacture = $data->prepare("SELECT * FROM libellesFacture WHERE ID_facture = :ID");
        $libellesFacture->execute(['ID' => $id]);
        $countLibelle=$libellesFacture->rowCount();
    }

    $_SESSION['error']=0;
    $sum=0;  $s=0; 

    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Visualiser une facture</title>
        <link rel="icon" type="image/png" href="icon.png" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">           
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="width:16px; float:right; height:30px; margin: 0px  6px;"></i></button>
            <img src="facture.png" class="navbar-brand ps-3" alt="img-thumbnail" style="width: 200px; text-align: center; margin: 0px  -16px;">
            
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $result['prenom'].' '.$result['nom']; ?> <i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href='reglages.php'>Réglages</a></li>
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
                            
                            <?php if ($result['role']=='administrateur'){?>
                            <a class="nav-link" href="etape1.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                                Créer des factures
                            </a>
                            <?php }?>

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
                        <h1 class="mt-4"><i class="fa fa-copy"></i> Facture <b class='text-success'> <?php echo $result2['numero']; ?></b></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item "><a class='text-success' href="dashboard.php">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Gestion des factures</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <p class="col-md-3 mb-0">
                                        Facture N° : <b class='text-success'> <?php echo $result2['numero']; ?></b></p>
                                    <p class="col-md-3 mb-0">
                                        Client : <b class='text-success'><?php echo $result2['client']; ?></b></p>
                                    <p class="col-md-6 mb-0">
                                        Objet : <b class='text-success'> <?php echo $result2['objet']; ?></b></p>
                                </div>
                                <?php if ($result2['reference']!=NULL && $result2['reference']!='upload'){ ?> <p> Réference : <b class='text-success'> <?php echo $result2['reference']; }?></b></p>

                                <table class="table table-bordered border-black">
                                    <thead>
                                        <tr>
                                            <th scope="col" class='bg-light col-5' style='text-align:center'>Désignations</th>
                                            <th scope="col" class='bg-light col-2' style='text-align:center'>Quantité</th>
                                            <?php if(!empty($result3['jours'])) {?><th scope="col" class='bg-light col-1' style='text-align:center'>Jours</th> <?php }?>
                                            <th scope="col" class='bg-light col-2' style='text-align:center'>Prix unitaire (DH,TTC)</th>
                                            <th scope="col" class='bg-light col-2' style='text-align:center'>Prix Total (DH,TTC)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result2['nature']=='formation' && $length==1){

                                            if (!empty($result3['jours'])) { 
                                                $s=$result3['quantite']*$result3['prix']*str_replace('T', '', $result3['jours']); 
                                                $sum+=$s;
                                            }else{
                                                $s=$result3['quantite']*$result3['prix']; 
                                                $sum+=$s;
                                            }
                                            ?>
                                        <tr>
                                            <td ><?php echo $result3['designation']; ?></td>
                                            <td style='text-align:center'><?php
                                                if ($result3['quantite']==1) echo $result3['quantite'].' personne'; 
                                                else echo $result3['quantite'].' personnes';
                                            ?></td>
                                            <?php if(!empty($result3['jours'])) {?><td><?php echo str_replace('T', '', $result3['jours']); ?> </td> <?php }?>
                                            <td style='text-align:center'><?php if ($result3['prix']!=0 ) echo number_format($result3['prix'], 2, ',', ' '); ?></td>
                                            <td style='text-align:center'><?php echo number_format($s, 2, ',', ' '); ?></td>
                                        </tr>
                                        <?php } if ($length>1){                       
                                            while ($ligne = $rq3 -> fetch()) {  ?>
                                            <tr>
                                                <td><?php echo $ligne['designation']; ?></td>
                                                <td style='text-align:center'><?php if ($ligne['quantite']!=0 ) echo $ligne['quantite']; else echo '-'; ?></td>
                                                <td style='text-align:center'><?php if ($ligne['prix']!=0 ) echo $ligne['prix'].',00'; else echo '-'; ?></td>
                                                <td style='text-align:center'><?php if ($ligne['prix']!=0 ) { $s=$ligne['quantite']*$ligne['prix']; $sum+=$s; echo number_format($sum, 2, ',', ' '); } else echo '-';  ?></td>
                                            </tr>
                                        <?php }}?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th scope="col" class='bg-light  col-4' style='text-align:center'>Total (DH,TTC)</th>
                                            <th scope="col" class='bg-light col-1' style='text-align:center'colspan="4" ><?php echo number_format($result2['prix_total'], 2, ',', ' '). ' DH'; ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                
                                <?php if($countLibelle!=0){
                                    while($libelle=$libellesFacture->fetch()){ ?>
                                        <p class="col-md-6 mb-0"> <?php echo $libelle['libelle']; ?>: <b class='text-success'> <?php echo number_format($libelle['prix'], 2, ',', ' '); if(empty($result2['devise'])) echo ' DHS'; else echo ' '.$result2['devise'];?> </b></p>
                                <?php }}?>
                                <br>
                                <div class="row mb-3">
                                    <p class="col-md-4 mb-0"> Facture éditée par : <b class='text-success'> <?php echo $result['prenom'].' '.$result['nom']; ?></b></p>
                                    <p class="col-md-3 mb-0"> Date de création : <b class='text-success'> <?php echo date('d/m/Y', strtotime($result2['date_creation']));?></b></p>
                                    <?php 
                                    $message='';
                                    if ($result2['reference']!='upload'){ 
                                        if ($result3['jours']!=0){ 
                                            if ($result3['jours'][strlen($result3['jours'])-1]=='T') $message =' - visualisée dans la facture'; 
                                    ?> 
                                    <p class="col-md-5 mb-0"> Nombres de Jours : <b class='text-success'> <?php echo str_replace('T', "",$result3['jours']).$message ; ?></b></p>
                                    <?php }} ?> 
                                </div>
                                <?php if (!empty($result2['ICE'])) {?><p>ICE : <b class='text-success'> <?php echo $result2['ICE']; ?></b></p> <?php }?>
                               
                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success">
                                                <h5 class="modal-title text-white" id="staticBackdropLabel">Attention</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form class="needs-validation" novalidate action='' method='post' enctype='multipart/form-data' >
                                                <div class="modal-body">
                                                    Après l'importation de la facture scannée (signée et cachetée) dans la plateforme, vous ne pourrez plus changer les informations liées à cette facture pour des raisons de sécurité.
                                                    <br><br>
                                                    <b><label class="col-md-4 mb-0"> Fichier à télécharger</label></b>
                                                    <input type="file" class="form-control bg-light col-md-2 mb-0" accept=".pdf" name="document" style='width:300px' required/>
                                                    <div class="invalid-tooltip">Vous devez choisir un fichier</div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger btn-block" data-bs-dismiss="modal">Quitter</button>
                                                    <button type="submit" name='import' class="btn btn-success btn-block">Importer le document</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                            </div> 
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
                        <?php if (empty($result2['document'])) {?>
                            <?php if ($result['role']=='administrateur') { ?>

                            <button type="button" class="btn btn-warning" onclick="window.location.href='/e-facture/modifierFacture.php?id='+<?php echo $id;?>" ><i class="fa fa-edit"></i> modifier</button>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-upload"></i> importer</button>
                            <?php }?>
                        <button type="button" class="btn btn-info" onclick="window.location.href='/e-facture/print.php?id='+<?php echo $id;?>" ><i class="fa fa-print"></i> imprimer</button>
                        <?php } ?>
                        <?php if ($result['role']=='administrateur') {?>
                        <button type="button" class="btn btn-danger" name='delete' data-bs-toggle="modal" data-bs-target="#supprimer"><i class="fa fa-trash-alt"></i> supprimer</button>
                        <?php } ?>
                        <?php if (!empty($result2['document'])) {?>
                            <button type="button" class="btn btn-success" onclick="window.location.href='/e-facture/facture.php?id='+<?php echo $id;?>" ><i class="fa fa-copy"></i> visualiser</button> 
                            <?php if ($result['role']=='administrateur') {?>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa fa-upload"></i> changer le document</button>
                            <?php } ?>

                            <br><br>
                            <div class="card mb-0 alert alert-info col-md-10" role="alert">
                                <div class="row  ">
                                    <div class='col-md-10 mb-0'><i class="fas fa-key fa-lg" ></i>  Vous ne pouvez plus modifier les informations liées à cette facture ou imprimer la facture non cachetée.</div>
                                    <div class='col-md-2 mb-0'>
                                        <button type="button" class="btn-close btn-info" data-bs-dismiss="alert" aria-label="Close" style='height:16px; margin: 0px  120px;'></button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>   
                    </div>
                </main>
                <br>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted"> <a class="text-dark" href="guide.php">Guide E-facture</a></div>
                            <div>
                                <a class='text-success'href="https://www.amee.ma/fr/home">AMEE</a>
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
    $rq3->execute(['ID' => $id]);
    ?><script> 
        window.location.assign("/e-facture/dashboard.php"); 
    </script> <?php
}

if (isset($_POST['import'])){

    include 'Database.php';
    global $data;
    extract($_POST);
    
    $rq3 = $data->prepare("UPDATE facture SET document=:doc WHERE ID =:ID");
    $rq3->execute([
        'ID' => $id, 
        'doc'=> file_get_contents($_FILES['document']['tmp_name'])
    ]);
} 
?>