<?php //  si l'utulisateur est non connecté alors bloquer la page de notifications 
    if (session_status()==PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['ID'])) header('Location: /e-facture/login.php');
    
    include 'Database.php';
    global $data;

    $rq = $data->prepare("SELECT * FROM utilisateurs WHERE ID = :ID");
    $rq->execute(['ID' => $_SESSION['ID']]);
    $result=$rq->fetch();
    if ($result['role']!='administrateur') header('Location: /e-facture/404.php');

    $rq2 = $data->prepare("SELECT * FROM banque");
    $rq2->execute();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stocker une facture</title>
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
                            
                            <a class="nav-link" href="etape1.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                                Créer des factures
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
                    <h1 class="mt-4"><i class="fa fa-cloud-upload-alt"></i> Stocker une facture <b class='text-success'> </b></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item "><a class='text-success' href="dashboard.php">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Stocker des factures</li>
                        </ol>

                        <div class="card mb-0 border-white">
                            <div class="card-body">
                                <form class="needs-validation" novalidate action='' method='post' enctype='multipart/form-data' >
                                    <div class="form-row">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <div class="form-floating mb-2 ">
                                                    <input class="form-control " name="numero" type="text"  placeholder="." required>
                                                    <label for="numero">Numéro de la facture </label>
                                                    <div class="invalid-tooltip">Champs obligatoire</div> 
                                                </div>
                                            </div>
                                            <div class="form-floating col-md-4 mb-2">
                                                <select class="form-select shadow-success" name="nature" placeholder="." required>
                                                    <option value=''>....</option>
                                                    <option value='formation'>Facture formation</option>
                                                    <option value='test performances'>Facture études et tests de performances</option>
                                                    <option value='autres'>Autres</option>
                                                </select>
                                                <label for="createur" style='margin: 0px  12px;'>Nature de facture</label>
                                                <div class="invalid-tooltip">Champs obligatoire</div> 
                                            </div>

                                            <div class="form-floating col-md-4 mb-2">
                                                <select class="form-select shadow-success" name="banque" placeholder="." required>
                                                    <option value=''>....</option>
                                                    <?php while($ligne=$rq2->fetch()) { ?>
                                                    <option value='<?php echo $ligne['ID'];?>'> <?php echo $ligne['agence'].' ['.$ligne['nature'].']'; ?></option>
                                                    <?php } ?>
                                                    </select>
                                                <label for="banque" style='margin: 0px  11px;'>Banque</label>
                                                <div class="invalid-tooltip">Vous devez choisir une réponse</div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" name="client" type="text"  placeholder="." required/>
                                                    <label for="client">Client </label>
                                                    <div class="invalid-tooltip">Champs obligatoire</div> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" name="objet" type="text"  placeholder="." required/>
                                                    <label for="objet">Objet de la facture</label>
                                                    <div class="invalid-tooltip">Champs obligatoire</div> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-8">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="obs" rows="8" placeholder="observations " ></textarea>
                                                    <label for="obs">Observations</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input class="form-control" name="prix" type="number" step="0.01" min='1' placeholder="1" required/>
                                                    <label for="prix">Prix total </label>
                                                    <div class="invalid-tooltip">Valeur non nulle !</div> 
                                                </div>
                                            </div>

                                        </div>
                                        <div class='row'>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input class="form-control" name="devise" type="text" placeholder="1" />
                                                    <label for="devise">Devise </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style='margin: -6px 0px;'> 
                                                <b><label> Fichier à importer (format: .pdf)</label></b>
                                                <input type="file" class="form-control bg-light" accept=".pdf" name="document" style='width:362px' required/>
                                                <div class="invalid-tooltip">Vous devez choisir un fichier</div>
                                            </div>
                                            <div class="col-md-2"  >
                                                <div style='margin: 0px 63px'>
                                                    <button type='submit' class="btn btn-primary" name='save' ><i class="fa fa-save"></i> enregistrer</button>
                                                    <br><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php 
                                    if (isset($_POST['save'])){

                                        global $data;
                                        extract($_POST);
                                        $error=0;
                                        if (!empty($numero) && !empty($nature) && !empty($banque) && !empty($client) && !empty($objet) && !empty($prix) && !empty($_FILES['document'])){ //facture formation
                                            $numero = str_replace(' ', '', $numero);
                                            $numero=strtoupper($numero);
                                            $rq2 = $data->prepare("SELECT numero FROM facture WHERE numero = :numero");
                                            $rq2->execute(['numero' => $numero]);
                                            $search= $rq2->rowCount();

                                            if ($search==0){
                                                $req= $data->prepare('INSERT INTO facture(numero,client,objet,nature,ID_banque,createur,date_creation,prix_total,document,reference) VALUES(:numero,:client,:objet,:nature,:banque,:createur,:date,:prix,:document,:ref)');
                                                $req->execute([
                                                    'numero'=>$numero,
                                                    'client'=>$client,
                                                    'objet'=>$objet,
                                                    'nature'=>$nature,
                                                    'banque'=>$banque,
                                                    'createur' => $_SESSION['ID'],
                                                    'date'=>date('y-m-d'),
                                                    'prix'=>$prix,
                                                    'document' =>file_get_contents($_FILES['document']['tmp_name']),
                                                    'ref' => 'upload'
                                                ]);

                                                $lastId = $data->lastInsertId();
                                                if (!empty($obs)){
                                                    $rq4 = $data->prepare("UPDATE facture  SET observations=:obs WHERE ID=:ID");
                                                    $rq4->execute(['obs' => $obs, 'ID'=> $lastId ]);
                                                }

                                                if (!empty($devise)){
                                                    $rq4 = $data->prepare("UPDATE facture  SET devise=:devise WHERE ID=:ID");
                                                    $rq4->execute(['devise' => $devise, 'ID'=> $lastId ]);
                                                }

                                            }else $error=1;
                                        
                                        if ($error==1){
                                        ?>
                                        <br>
                                        <div class="card mb-0 alert alert-danger" role="alert">
                                            <div class="row ">
                                                <div class='col-md-10 mb-0'><i class="fas fa-exclamation-triangle fa-lg" ></i>  Ce numéro de facture existe déjà, Veuillez chercher ce numéro dans <a class='text-danger' href='searchFactures.php' >Gestion de factures</a> </div>
                                                <div class='col-md-2 mb-0'>
                                                    <button type="button" class="btn-close btn-danger" data-bs-dismiss="alert" aria-label="Close" style='height:16px; margin: 0px  120px;'></button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    <?php }else{?>
                                        <br>
                                        <div class="card mb-0 alert alert-info col-md-8" role="alert">
                                            <div class="row ">
                                                <div class='col-md-9 mb-0'><i class="fas fa-check fa-lg" ></i> <b> La facture est bien enregistrée dans la plateforme.</b> </div>
                                                <div class='col-md-3 mb-0'>
                                                    <button type="button" class="btn-close btn-info" data-bs-dismiss="alert" aria-label="Close" style='height:16px; margin: 0px  120px;'></button>
                                                </div>
                                            </div>
                                        </div>
                                <?php }}}?>
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
            /*La fonction principale de ce script est d'empêcher l'envoi du formulaire si un champ a été mal rempli
             *et d'appliquer les styles de validation aux différents éléments de formulaire*/
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


