<?php //  si l'utulisateur est non connecté alors bloquer la page de notifications 
    if (session_status()==PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['ID'])){ header('Location: /e-facture/login.php'); exit(); }
    if ($_SESSION['acces']!=2) header('Location: /e-facture/404.php');
    
    include 'Database.php';
    global $data;
    $rq = $data->prepare("SELECT * FROM utilisateurs WHERE ID = :ID");
    $rq->execute(['ID' => $_SESSION['ID']]);
    $result=$rq->fetch();
    $rq2 = $data->prepare("SELECT * FROM facture WHERE ID = :ID");
    $rq2->execute(['ID' => $_SESSION['IDfacture']]);
    $result2=$rq2->fetch();
    $error='';

    $rq=$data->prepare('SELECT * FROM banque WHERE ID=:ID');
    $rq->execute([ 'ID' => $result2['ID_banque'] ]);
    $bank=$rq->fetch();
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
                        <h1 class="mt-4">Création de factures</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item "><a class='text-success' href="index.html">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Créer des factures</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-body">
                                
                                <div class="progress" style="height: 20px">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: 70%" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">70% Etape 2</div>
                                </div>
                                <br>
                                <div class="row mb-5">
                                    <p class="col-md-3 mb-0">
                                        Facture N° : <b class='text-success'> <?php echo $result2['numero']; ?></b></p>
                                    <p class="col-md-3 mb-0">
                                        Client : <b class='text-success'> <?php echo $result2['client']; ?></b></p>
                                    <p class="col-md-6 mb-0">
                                        Objet : <b class='text-success'> <?php echo $result2['objet']; ?></b></p>
                                </div>

                                <?php if($result2['nature']!='test performances'){ ?>
                                    <div class="row mb-3">
                                        <p class="col-md-3 mb-0" >Choix de sessions de la formation : </p>
                                        <div class="col-md-2">
                                            <button id="togg1" type="button" class="btn btn-outline-success btn-sm ">une session</button> 
                                        </div>
                                        <div class="col-md-6">
                                            <button id="togg2" type="button" class="btn btn-outline-success btn-sm col-md-3">plusieurs sessions</button>
                                        </div>
                                    </div>
                                <?php }else{ ?>
                                    <div class="row mb-3">
                                        <p class="col-md-3 mb-0" >Gestion de produits financiers : </p>
                                        <div class="col-md-1">
                                            <button id="togg1" type="button" class="btn btn-outline-success btn-sm ">Simple</button> 
                                        </div>
                                        <div class="col-md-6">
                                            <button id="togg2" type="button" class="btn btn-outline-success btn-sm col-md-3">Personalisé</button>
                                        </div>
                                    </div>
                                <?php } ?>    

                                <div id="d1">
                                    <form class="needs-validation" novalidate action='' method="post">
                                        <div class="form-row">
                                            <div class="form-floating mb-3 ">          
                                                <textarea class="form-control" name="designation" rows="8" placeholder="." required></textarea>
                                                <label for="designation">Designation</label>
                                                <div class="invalid-feedback">Champs obligatoire</div>
                                            </div>
                                            <div class="row mb-3">
                                                <?php if($result2['nature']=='formation'){ ?>

                                                    <div class="col-md-4">
                                                        <div class="form-floating">
                                                            <input class="form-control" name="quantite" type="number" placeholder="1" min='1' required>
                                                            <label for="quantite">Quantité</label>
                                                            <div class="invalid-feedback">Champs obligatoire</div>
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                                <?php if ($bank['nature']!='nationale') { ?>
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="prix" type="number" placeholder="1" step="0.01" min='1' required/>
                                                        <label for="prix">Prix unitaire </label>
                                                        <div class="invalid-feedback">Champs obligatoire</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="devise" type="text" placeholder="1" />
                                                        <label for="devise">Devise </label>
                                                    </div>
                                                </div>
                                                <?php }else { ?>
                                                
                                                <div class="col-md-8">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="prix" type="number" placeholder="1" step="0.01" min='1' required/>
                                                        <label for="prix">Prix unitaire </label>
                                                        <div class="invalid-feedback">Champs obligatoire</div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-8">
                                                    <div class="form-floating">
                                                        <textarea class="form-control" name="obs" rows="8" placeholder="." ></textarea>
                                                        <label for="obs">Observations</label>
                                                    </div>
                                                </div>

                                                <?php if($result2['nature']=='formation'){ ?>
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="jours" type="number" placeholder="1" min='1'/>
                                                        <label for="jours">Nombres de jours</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="verifyJours" type="checkbox" value="oui" />
                                                <label class="form-check-label" for="verifyJours">Afficher le nombre de jours dans la facture</label>
                                            </div>

                                            <?php } else { ?> </div> <?php } ?>
                                                            
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button class="btn btn-success btn-block" type='submit' name='session'><i class="fa fa-vote-yea"></i>  Valider la désignation</button></div>
                                        </div>
                                    </form>

                                    <?php
                                        if (isset($_POST['session'])) {
                                            extract($_POST);
                                            global $data;
                                            
                                            if (!empty($designation) && !empty($quantite) && !empty($prix)){ //facture formation
                                                $rq3= $data->prepare('INSERT INTO designation(ID_facture,designation,prix,quantite) VALUES(:ID_facture,:designation,:prix,:quantite)');
                                                $rq3->execute([
                                                    'ID_facture'=>$_SESSION['IDfacture'],
                                                    'designation'=>$designation,
                                                    'prix'=>$prix,
                                                    'quantite'=>$quantite
                                                ]);

                                                $lastId = $data->lastInsertId();

                                                if (!empty($obs)){
                                                    $rq4 = $data->prepare("UPDATE facture  SET observations=:obs WHERE ID=:ID");
                                                    $rq4->execute(['obs' => $obs, 'ID'=> $_SESSION['IDfacture']]);
                                                }

                                                if (!empty($devise)){
                                                    $devise=strtoupper($devise);
                                                    $rq4 = $data->prepare("UPDATE facture  SET devise=:devise WHERE ID=:ID");
                                                    $rq4->execute(['deivse' => $devise, 'ID'=> $_SESSION['IDfacture']]);
                                                }

                                                if (!empty($jours) && !empty($verifyJours)){
                                                    $jours.='T';
                                                    $rq4 = $data->prepare("UPDATE designation  SET jours=:jours WHERE ID=:ID");
                                                    $rq4->execute(['jours' => $jours, 'ID'=> $lastId]);

                                                }elseif (empty($jours) && !empty($verifyJours)){
                                                    $error= 'Pour afficher le nombre de jours dans la facture, vous devez remplir la case "nombres de jours de la formation"';
                                                }

                                                $_SESSION['acces']=3;
                                                ?><script> 
                                                    window.location.assign("/e-facture/etape3.php"); 
                                                </script> <?php

                                            }else if (!empty($designation) && empty($quantite) && !empty($prix) && $result2['nature']=='test performances'){ //facture tests
                                                $rq3= $data->prepare('INSERT INTO designation(ID_facture,designation,prix,quantite) VALUES(:ID_facture,:designation,:prix,:quantite)');
                                                $rq3->execute([
                                                    'ID_facture'=>$_SESSION['IDfacture'],
                                                    'designation'=>$designation,
                                                    'prix'=>$prix,
                                                    'quantite'=>1
                                                ]);

                                                if (!empty($obs)){
                                                    $rq4 = $data->prepare("UPDATE facture  SET observations=:obs WHERE ID=:ID");
                                                    $rq4->execute(['obs' => $obs, 'ID'=> $_SESSION['IDfacture']]);
                                                }
                                                $_SESSION['acces']=3;
                                                ?><script> 
                                                    window.location.assign("/e-facture/etape3.php"); 
                                                </script> <?php
                                            }
                                        }
                                    if (!empty($error)){ ?> 
                                    <br>
                                    <div class="card mb-0 alert alert-danger" role="alert">
                                        <div class="row ">
                                            <div class='col-md-10 mb-0'><i class="fas fa-exclamation-triangle fa-lg" ></i>  <?php echo $error;?></div>
                                            <div class='col-md-2 mb-0'>
                                                <button type="button" class="btn-close btn-danger" data-bs-dismiss="alert" aria-label="Close" style='height:16px; margin: 0px  120px;'></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } $error=''; ?>
                                </div>


                                <div id="d2">
                                    <?php if($result2['nature']!='test performances'){ ?>
                                    <br>
                                    <form class="needs-validation" novalidate action='' method='post'>
                                        <div class="form-row">        
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" name="designation" rows="8" placeholder="." required></textarea>
                                                <label for="designation">Designation</label>
                                                <div class="invalid-feedback">Champs obligatoire</div>
                                            </div>

                                            <?php if ($bank['nature']!='nationale') { ?>
                                            <div class="row mb-3">        
                                                <div class="col-md-8">
                                                    <div class="form-floating">
                                                        <textarea class="form-control" name="obs" rows="8" placeholder="." ></textarea>
                                                        <label for="obs">Observations</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="devise" type="text" placeholder="1" />
                                                        <label for="devise">Devise </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } else {?>

                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" name="obs" rows="8" placeholder="." ></textarea>
                                                <label for="obs">Observations</label>
                                            </div>

                                            <?php } ?>
                                                
                                            <table class="table table-bordered border-success">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class='bg-success text-white-50 col-6'>Opérations</th>
                                                        <th scope="col" class='bg-success text-white-50 col-1'>PU/Session</th>
                                                        <th scope="col" class='bg-success text-white-50 col-1'>Nbr session</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr class='bg-light'>
                                                        <td>
                                                            <textarea class="form-control" name="op[]" rows="1" placeholder="Opération 1" required></textarea>
                                                            <div class="invalid-feedback">Vous devez éditer au moins une opération pour valider la facture</div>
                                                        </td>
                                                        <td>        
                                                            <input class="form-control" name="prix[]" type="number" step="0.01" min='1' required>
                                                            <div class="invalid-feedback">Valeur incorrecte</div>       
                                                        </td>
                                                            
                                                        <td>
                                                            <input class="form-control" name="quantite[]" type="number" min='1' required>
                                                            <div class="invalid-feedback">Valeur incorrecte</div> 
                                                        </td>
                                                    </tr>

                                                    <tr class='bg-light'>
                                                        <td><textarea class="form-control" name="op[]" rows="1" placeholder="Opération 2"></textarea></td>
                                                        <td><input class="form-control" name="prix[]" type="number" step="0.01" min='1' ></td>
                                                        <td><input class="form-control" name="quantite[]" type="number" min='1' ></td>
                                                    </tr>

                                                    <tr class='bg-light'>
                                                        <td><textarea class="form-control" name="op[]" rows="1" placeholder="Opération 3" ></textarea></td>
                                                        <td><input class="form-control" name="prix[]" type="number" step="0.01" min='1' ></td>                                                            
                                                        <td><input class="form-control" name="quantite[]" type="number" min='1'></td>
                                                    </tr>
                                                    
                                                    <tr class='bg-light'>
                                                        <td><textarea class="form-control" name="op[]" rows="1" placeholder="Opération 4" ></textarea></td>
                                                        <td><input class="form-control" name="prix[]" type="number" step="0.01" min='1' ></td>                                                            
                                                        <td><input class="form-control" name="quantite[]" type="number" min='1' ></td>
                                                    </tr>   

                                                    <tr class='bg-light'>
                                                        <td><textarea class="form-control" name="op[]" rows="1" placeholder="Opération 5" ></textarea></td>
                                                        <td><input class="form-control" name="prix[]" type="number" step="0.01" min='1' ></td>                                                            
                                                        <td><input class="form-control" name="quantite[]" type="number" min='1'></td>
                                                    </tr>  

                                                    <tr class='bg-light'>
                                                        <td><textarea class="form-control" name="op[]" rows="1" placeholder="Opération 6" ></textarea></td>
                                                        <td><input class="form-control" name="prix[]" type="number" step="0.01" min='1' ></td>                                                            
                                                        <td><input class="form-control" name="quantite[]" type="number" min='1' ></td>
                                                    </tr> 
                                                    
                                                    <tr class='bg-light'>
                                                        <td><textarea class="form-control" name="op[]" rows="1" placeholder="Opération 7" ></textarea></td>
                                                        <td><input class="form-control" name="prix[]" type="number" step="0.01" min='1'></td>                                                            
                                                        <td><input class="form-control" name="quantite[]" type="number" min='1' ></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button class="btn btn-success btn-block" type='submit' name='multipleSesssions'><i class="fa fa-vote-yea"></i>  Valider la désignation</button></div>
                                        </div>
                                    </form>
                                      
                                    <?php } else { //facture tests performances personalisée?> 

                                    <div class="row">
                                        <p class="col-md-3 "> Nombre de champs vides : </p>
                                        <div class="col-md-2" style='margin: 0px  -50px;'>
                                            <button id="togg3" type="button" class="btn btn-outline-success btn-sm ">2 lignes</button> 
                                        </div>
                                        <div class="col-md-4" style='margin: 0px  -42px;'>
                                            <button id="togg4" type="button" class="btn btn-outline-success btn-sm col-md-3">3 lignes</button>
                                        </div>
                                    </div>
                                    
                                <div id="d3"> 
                                    <br>
                                    <form class="needs-validation" novalidate action='' method='post'>
                                        <div class="form-row"> 
                                            <div class="row mb-3">        
                                                <div class="col-md-10">      
                                                    <div class="form-floating">
                                                        <textarea class="form-control" name="designation" rows="8" placeholder="." required></textarea>
                                                        <label for="designation">Designation</label>
                                                        <div class="invalid-feedback">Champs obligatoire</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="prix" type="number" placeholder="1" step="0.01" min='1' required/>
                                                        <label for="prix">Prix total</label>
                                                        <div class="invalid-feedback">Montant invalide</div> 
                                                    </div>
                                                </div>  
                                            </div>    

                                            <?php if ($bank['nature']!='nationale') { ?>
                                            <div class="row mb-3">        
                                                <div class="col-md-8">
                                                    <div class="form-floating">
                                                        <textarea class="form-control" name="obs" rows="8" placeholder="." ></textarea>
                                                        <label for="obs">Observations</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="devise" type="text" placeholder="1" />
                                                        <label for="devise">Devise </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } else {?>

                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" name="obs" rows="8" placeholder="." ></textarea>
                                                <label for="obs">Observations</label>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <b>Veuillez calculer les montants manuellement puis saisissez les données dans les cases correspondantes.</b>
                                        <div class="row mb-3">        
                                            <div class="col-md-9">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="libelle1" rows="8" placeholder="." required>TOTAL (DH,TTC)</textarea>
                                                    <label for="libelle1">Libellé 1</label>
                                                    <div class="invalid-feedback">Champs obligatoire</div> 
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" name="prix1" type="number" placeholder="1" step="0.01" min='1' required/>
                                                    <label for="prix1">Montant du libellé 1</label>
                                                    <div class="invalid-feedback">Montant invalid</div> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">        
                                            <div class="col-md-9">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="libelle2" rows="8" placeholder="." required>ACOMPTE 75% À LA SIGNATURE DU CONTRAT</textarea>
                                                    <label for="libelle2">Libellé 2</label>
                                                    <div class="invalid-feedback">Champs obligatoire</div> 
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" name="prix2" type="number" placeholder="1" step="0.01" min='1' required/>
                                                    <label for="prix2">Montant du libellé 2</label>
                                                    <div class="invalid-feedback">Montant invalid</div> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button class="btn btn-success btn-block" type='submit' name='2champs'><i class="fa fa-vote-yea"></i>  Valider la désignation</button></div>
                                        </div>
                                    </form>
                                </div>
                                        
                                <div id="d4">
                                    <br>
                                    <form class="needs-validation" novalidate action='' method='post'>
                                        <div class="form-row">        
                                            <div class="row mb-3">        
                                                <div class="col-md-10">      
                                                    <div class="form-floating">
                                                        <textarea class="form-control" name="designation" rows="8" placeholder="." required></textarea>
                                                        <label for="designation">Designation</label>
                                                        <div class="invalid-feedback">Champs obligatoire</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="prix" type="number" placeholder="1" step="0.01" min='1' required/>
                                                        <label for="prix">Prix total</label>
                                                        <div class="invalid-feedback">Montant invalid</div> 
                                                    </div>
                                                </div>  
                                            </div>

                                            <?php if ($bank['nature']!='nationale') { ?>
                                            <div class="row mb-3">        
                                                <div class="col-md-8">
                                                    <div class="form-floating">
                                                        <textarea class="form-control" name="obs" rows="8" placeholder="." ></textarea>
                                                        <label for="obs">Observations</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="devise" type="text" placeholder="1" />
                                                        <label for="devise">Devise </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } else {?>

                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" name="obs" rows="8" placeholder="." ></textarea>
                                                <label for="obs">Observations</label>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <b>Veuillez calculer les montants manuellement puis saisissez les données dans les cases correspondantes.</b>
                                        <div class="row mb-3">        
                                            <div class="col-md-9">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="libelle1" rows="8" placeholder="." required>MONTANT DU SOLDE RESTANT (20% DH,HT)</textarea>
                                                    <label for="libelle1">Libellé 1</label>
                                                    <div class="invalid-feedback">Champs obligatoire</div> 
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" name="prix1" type="number" placeholder="1" step="0.01" min='1' required/>
                                                    <label for="prix1">Montant du libellé 1 </label>
                                                    <div class="invalid-feedback">Montant invalid</div> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">        
                                            <div class="col-md-9">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="libelle2" rows="8" placeholder="." required>MONTANT TVA (20%)</textarea>
                                                    <label for="libelle2">Libellé 2</label>
                                                    <div class="invalid-feedback">Champs obligatoire</div> 
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" name="prix2" type="number" placeholder="1" step="0.01" min='1' required/>
                                                    <label for="prix2">Montant du libellé 2</label>
                                                    <div class="invalid-feedback">Montant invalid</div> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">        
                                            <div class="col-md-9">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="libelle3" rows="8" placeholder="." required>MONTANT DU SOLDE A REGLER (DH,TTC)</textarea>
                                                    <label for="libelle3">Libellé 3</label>
                                                    <div class="invalid-feedback">Champs obligatoire</div> 
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" name="prix3" type="number" placeholder="1" step="0.01" min='1' required/>
                                                    <label for="prix3">Montant du libellé 3</label>
                                                    <div class="invalid-feedback">Montant invalid</div> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button class="btn btn-success btn-block" type='submit' name='3champs'><i class="fa fa-vote-yea"></i>  Valider la désignation</button></div>
                                        </div>
                                    </form>     
                                </div> 
                                    <?php } ?>   
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
                                <a href="https://www.amee.ma/fr/home">AMEE</a>
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

            let togg1 = document.getElementById("togg1");
            let togg2 = document.getElementById("togg2");
            let d1 = document.getElementById("d1");
            let d2 = document.getElementById("d2");

            let togg3 = document.getElementById("togg3");
            let togg4 = document.getElementById("togg4");
            let d3 = document.getElementById("d3");
            let d4 = document.getElementById("d4");

            d1.style.display = "none";
            d2.style.display = "none";

            d3.style.display = "none";
            d4.style.display = "none";

            togg1.addEventListener("click", () => {
            if(getComputedStyle(d1).display != "none"){
                d1.style.display = "none";
                
            } else {
                d1.style.display = "block";
                d2.style.display = "none";
            }
            })

            function togg(){
            if(getComputedStyle(d2).display != "none"){
                d2.style.display = "none";
                
            } else {
                d2.style.display = "block";
                d1.style.display = "none";
            }
            };
            togg2.onclick = togg;

            //toggL pour les lignes de champs tests

            togg4.addEventListener("click", () => {
            if(getComputedStyle(d4).display != "none"){
                d4.style.display = "none";
                
            } else {
                d4.style.display = "block";
                d3.style.display = "none";
            }
            })

            function toggL(){
            if(getComputedStyle(d3).display != "none"){
                d3.style.display = "none";
                
            } else {
                d3.style.display = "block";
                d4.style.display = "none";
            }
            };
            togg3.onclick = toggL;
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php

if (isset($_POST['multipleSesssions'])) {
    extract($_POST);
    global $data;
    
    if (!empty($designation)){
        $rq3= $data->prepare('INSERT INTO designation(ID_facture,designation,prix,quantite) VALUES(:ID_facture,:designation,:prix,:quantite)');
        $rq3->execute([
            'ID_facture'=>$_SESSION['IDfacture'],
            'designation'=>$designation,
            'prix'=>0,
            'quantite'=>0
        ]);
        for ($i=0;$i<7;$i++){
            if (!empty($op[$i]) && !empty($prix[$i]) && !empty($quantite[$i])){
                $rq= $data->prepare('INSERT INTO designation(ID_facture,designation,prix,quantite) VALUES(:ID_facture,:designation,:prix,:quantite)');
                $rq->execute([
                    'ID_facture'=>$_SESSION['IDfacture'],
                    'designation'=>$op[$i],
                    'prix'=> $prix[$i],
                    'quantite'=>$quantite[$i]
                ]);
            }
        }
        if (!empty($devise)){
            $devise=strtoupper($devise);
            $rq4 = $data->prepare("UPDATE facture  SET devise=:devise WHERE ID=:ID");
            $rq4->execute(['deivse' => $devise, 'ID'=> $_SESSION['IDfacture']]);
        }

        if (!empty($obs)){
            $rq4 = $data->prepare("UPDATE facture  SET observations=:obs WHERE ID=:ID");
            $rq4->execute(['obs' => $obs, 'ID'=> $_SESSION['IDfacture']]);
        }
        $_SESSION['acces']=3;
        ?><script> 
            window.location.assign("/e-facture/etape3.php"); 
        </script> <?php
    }
}

if (isset($_POST['2champs'])) { // facture test de 2 champs
    extract($_POST);
    global $data;
    
    if (!empty($designation) && !empty($prix) && $result2['nature']=='test performances'){ //facture tests
        $rq3= $data->prepare('INSERT INTO designation(ID_facture,designation,prix,quantite) VALUES(:ID_facture,:designation,:prix,:quantite)');
        $rq3->execute([
            'ID_facture'=>$_SESSION['IDfacture'],
            'designation'=>$designation,
            'prix'=>$prix,
            'quantite'=>1
        ]);

        if (!empty($obs)){
            $rq4 = $data->prepare("UPDATE facture  SET observations=:obs WHERE ID=:ID");
            $rq4->execute(['obs' => $obs, 'ID'=> $_SESSION['IDfacture']]);
        }

        if (!empty($libelle1) && !empty($prix1) ){
            $rq4 = $data->prepare("INSERT INTO libellesFacture(ID_facture,libelle,prix) VALUES(:ID_facture,:libelle,:prix)");
            $rq4->execute([
                'ID_facture'=> $_SESSION['IDfacture'],
                'libelle'=> $libelle1,
                'prix'=> $prix1
            ]);
        }

        if (!empty($libelle2) && !empty($prix2) ){
            $rq4 = $data->prepare("INSERT INTO libellesFacture(ID_facture,libelle,prix) VALUES(:ID_facture,:libelle,:prix)");
            $rq4->execute([
                'ID_facture'=> $_SESSION['IDfacture'],
                'libelle'=> $libelle2,
                'prix'=> $prix2
            ]);
        }

        $_SESSION['acces']=3;
        ?><script> 
            window.location.assign("/e-facture/etape3.php"); 
        </script> <?php
    }
}

if (isset($_POST['3champs'])) { // facture test de 3 champs
    extract($_POST);
    global $data;
    
    if (!empty($designation) && !empty($prix) && $result2['nature']=='test performances'){ //facture tests
        $rq3= $data->prepare('INSERT INTO designation(ID_facture,designation,prix,quantite) VALUES(:ID_facture,:designation,:prix,:quantite)');
        $rq3->execute([
            'ID_facture'=>$_SESSION['IDfacture'],
            'designation'=>$designation,
            'prix'=>$prix,
            'quantite'=>1
        ]);

        if (!empty($obs)){
            $rq4 = $data->prepare("UPDATE facture  SET observations=:obs WHERE ID=:ID");
            $rq4->execute(['obs' => $obs, 'ID'=> $_SESSION['IDfacture']]);
        }

        if (!empty($libelle1) && !empty($prix1) ){
            $rq4 = $data->prepare("INSERT INTO libellesFacture(ID_facture,libelle,prix) VALUES(:ID_facture,:libelle,:prix)");
            $rq4->execute([
                'ID_facture'=> $_SESSION['IDfacture'],
                'libelle'=> $libelle1,
                'prix'=> $prix1
            ]);
        }

        if (!empty($libelle2) && !empty($prix2) ){
            $rq4 = $data->prepare("INSERT INTO libellesFacture(ID_facture,libelle,prix) VALUES(:ID_facture,:libelle,:prix)");
            $rq4->execute([
                'ID_facture'=> $_SESSION['IDfacture'],
                'libelle'=> $libelle2,
                'prix'=> $prix2
            ]);
        }

        if (!empty($libelle3) && !empty($prix3) ){
            $rq4 = $data->prepare("INSERT INTO libellesFacture(ID_facture,libelle,prix) VALUES(:ID_facture,:libelle,:prix)");
            $rq4->execute([
                'ID_facture'=> $_SESSION['IDfacture'],
                'libelle'=> $libelle3,
                'prix'=> $prix3
            ]);
        }

        $_SESSION['acces']=3;
        ?><script> 
            window.location.assign("/e-facture/etape3.php"); 
        </script> <?php
    }
}
    
?>