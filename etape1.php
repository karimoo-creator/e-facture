<?php //  si l'utulisateur est non connecté alors bloquer la page de notifications 
    if (session_status()==PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['ID'])){ header('Location: /e-facture/login.php'); exit(); }
    if ($_SESSION['acces']!=1 ) header('Location: /e-facture/404.php');
    
    include 'Database.php';
    global $data;
    $rq = $data->prepare("SELECT * FROM utilisateurs WHERE ID = :ID");
    $rq->execute(['ID' => $_SESSION['ID']]);
    $result=$rq->fetch();

    if ($result['role']!='administrateur') header('Location: /e-facture/404.php');
    $rq2 = $data->prepare("SELECT * FROM banque");
    $rq2->execute();


    $error=0;
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
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Tableau de bord
                            </a>
                            
                            <a class="nav-link" href="factures.php">
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
                            <li class="breadcrumb-item "><a class='text-success' href="dashboard.php">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Créer des factures</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-body">
                                <p class="mb-0">
                                    Veuillez remplir <b class='text-success'> les informations demandées</b> ci-dessous.

                                </p>
                                <div class="progress" style="height: 20px">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: 30%" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40% Etape 1</div>
                                </div>
                                <br>
                                <form class="needs-validation" novalidate  action='' method='POST'>
                                    <div class="form-row">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" name="numero" type="text" placeholder="." required>
                                                    <label for="numero">Numéro de la facture </label>
                                                    <div class="invalid-feedback">Champs obligatoire</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" name="client" type="text" placeholder="." required/>
                                                    <label for="client">Client </label>
                                                    <div class="invalid-feedback">Champs obligatoire</div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <select class="form-select shadow-success" name="nature" placeholder="." required>
                                                        <option value=''>....</option>
                                                        <option value='test performances'>Etudes et tests de performances</option>
                                                        <option value='formation'>Formation</option>
                                                        </select>
                                                    <label for="nature" >Nature de la facture</label>
                                                    <div class="invalid-feedback">Vous devez choisir une réponse</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control" name="ice" type="text" placeholder=".">
                                                    <label for="ice">ICE </label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-9">
                                                <div class="form-floating">
                                                    <input class="form-control " name="objet" type="text" placeholder="." required>
                                                    <label for="objet">Objet de la facture </label>
                                                    <div class="invalid-feedback">Champs obligatoire</div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select class="form-select shadow-success" name="banque" placeholder="." required>
                                                        <option value=''>....</option>
                                                        <?php while($ligne=$rq2->fetch()) { ?>
                                                        <option value='<?php echo $ligne['ID'];?>'><?php echo $ligne['agence'].' ['.$ligne['nature'].']'; ?></option>
                                                        <?php } ?>
                                                        </select>
                                                    <label for="banque">Banque</label>
                                                    <div class="invalid-feedback">Vous devez choisir une réponse</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" name="reference" type="text" placeholder=".">
                                                    <label for="reference">Référence </label>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                
                                            </div>
                                    
                                        </div>
                                    </div>
                                    <div class="mt-4 mb-0">
                                        <div class="d-grid"><button class="btn btn-success btn-block" name='create' type='submit'><i class="fa fa-file-alt"></i>  Créer la facture</button></div>
                                    </div>
                                    </form>
                                    <?php 
                                    if (isset($_POST['create'])) {
                                        extract($_POST);
                                        global $data;
                                        
                                        if (!empty($numero) && !empty($client) && !empty($objet) && !empty($nature) && !empty($banque)){
                                            //elimination des espaces
                                            $numeroFact = str_replace(' ', '', $numero);
                                            $numero=strtoupper($numero);
                                            $rq2 = $data->prepare("SELECT numero FROM facture WHERE numero = :numero");
                                            $rq2->execute(['numero' => $numeroFact]);
                                            $result2= $rq2->rowCount();

                                            if ($result2==0){
                                                
                                                $req= $data->prepare('INSERT INTO facture(numero,client,objet,nature,ID_banque,createur,date_creation) VALUES(:numero,:client,:objet,:nature,:banque,:createur,:date)');
                                                $req->execute([
                                                    'numero'=>$numeroFact,
                                                    'client'=>$client,
                                                    'objet'=>$objet,
                                                    'nature'=>$nature,
                                                    'banque'=>$banque,
                                                    'createur' => $_SESSION['ID'],
                                                    'date'=>date('y-m-d')
                                                ]);

                                                $lastId = $data->lastInsertId();

                                                if (!empty($reference)){
                                                    $rq3 = $data->prepare("UPDATE facture  SET reference=:reference WHERE ID=:ID");
                                                    $rq3->execute(['ID' => $lastId, 'reference'=> $reference]);
                                                }

                                                if (!empty($ice)){
                                                    $rq3 = $data->prepare("UPDATE facture  SET ICE=:ice WHERE ID=:ID");
                                                    $rq3->execute(['ID' => $lastId, 'ice'=> $ice]);
                                                }


                                                $_SESSION['acces']=2;
                                                $_SESSION['IDfacture']=$lastId;
                                                ?><script> 
                                                    window.location.assign("/e-facture/etape2.php?id="+<?php echo $lastId;?>); 
                                                </script> <?php
                                                
                                            }else { $error=1; } 
                                        }
                                    }   
                                    if ($error==1){?>
                                    <br>
                                    <div class="card mb-0 alert alert-danger" role="alert">
                                        <div class="row ">
                                            <div class='col-md-10 mb-0'><i class="fas fa-exclamation-triangle fa-lg" ></i>  Ce numéro de facture existe déjà, Veuillez chercher ce numéro dans <a class='text-danger' href='searchFactures.php' >Gestion de factures</a> </div>
                                            <div class='col-md-2 mb-0'>
                                                <button type="button" class="btn-close btn-danger" data-bs-dismiss="alert" aria-label="Close" style='height:16px; margin: 0px  120px;'></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                            </div>
                        </div>
                        <img class="d-block w-100" src="fiche2.jpg" alt="Second slide" width="1000" height="400">
                        <br>
                    </div>

                </main>
                
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <a class="text-muted" href="guide.php">Guide E-facture</a>
                            <div>
                                <a class="text-success"href="https://www.amee.ma/fr/home">AMEE</a>
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

