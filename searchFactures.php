<?php //  si l'utulisateur est non connecté alors bloquer la page de notifications 
    if (session_status()==PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['ID'])) header('Location: /e-facture/login.php');
    
    include 'Database.php';
    global $data;
    $rq = $data->prepare("SELECT * FROM utilisateurs WHERE ID = :ID");
    $rq->execute(['ID' => $_SESSION['ID']]);
    $result=$rq->fetch();

    $mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
    $length=0;

    $rq2 = $data->prepare("SELECT * FROM utilisateurs");
    $rq2->execute();

    $bank = $data->prepare("SELECT * FROM banque");
    $bank->execute();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>E-facture</title>
        <link rel="icon" type="image/png" href="icon.png" />
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="width:16px; float:right; height:30px; margin: 0px  6px;"></i></button>
            <!--  <a class="navbar-brand ps-3" href="index.html">E-facture</a> -->
            <img src="facture.png" class="navbar-brand ps-3" alt="img-thumbnail" style="width: 200px; text-align: center; margin: 0px  -16px;" >
            
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
                        <h1 class="mt-4"><i class="fa fa-search"></i> Recherche de factures</h1>
                        
                        <div class="card mb-4">
                            <div class="card-body">
                                <form class="needs-validation" novalidate action='' method='POST'>
                                    <div class="form-row">
                                        <div class="row mb-1"> 
                                            <div class="form-floating col-md-4 mb-2">                            
                                                <input class="form-control " name="client" type="text" placeholder=".">
                                                <label for="client" style='margin: 0px  12px;'>Client</label>
                                            </div>

                                            <div class="form-floating col-md-4 mb-2">
                                                <select class="form-select shadow-success" name="nature" placeholder=".">
                                                    <option value='0'>....</option>
                                                    <option value='formation'>Facture formation</option>
                                                    <option value='test performances'>Facture études et tests de performances</option>
                                                    <option value='autres'>Autres</option>

                                                </select>
                                                <label for="createur" style='margin: 0px  12px;'>Nature de facture</label>
                                            </div>

                                            <div class="form-floating col-md-4 mb-2">
                                                <select class="form-select shadow-success" name="type" placeholder=".">
                                                    <option value='0'>....</option>
                                                    <?php while ($ligne = $bank -> fetch()) { ?>
                                                        <option value='<?php echo $ligne['ID']; ?>'><?php echo $ligne['agence'].'  ['.$ligne['nature'].']'; ?></option>
                                                    <?php }?>
                                                </select>
                                                <label for="type" style='margin: 0px  12px;'>Banque</label>
                                            </div>
                                        
                                            <div class="row mb-2">
                                                <div class="form-floating col-md-4 mb-0">
                                                    <select class="form-select shadow-success" name="createur" placeholder=".">
                                                        <option value='0'>....</option>
                                                        <?php while ($ligne = $rq2 -> fetch()) { ?>
                                                        <option value='<?php echo $ligne['ID']; ?>'><?php echo $ligne['prenom'].' '.$ligne['nom']; ?></option>
                                                        <?php }?>
                                                    </select>
                                                    <label for="nature" style='margin: 0px  12px;'>Créateur de facture</label>
                                                </div>

                                                <p class="col-md-2 mb-0 ">Date de facture :   De </p>

                                                <div class="col-md-2 mb-0">                      
                                                    <input class="form-control" name="date1" type="date" placeholder=".">
                                                </div>

                                                <p class="col-md-1 ">À</p>
                                                    <div class="col-md-2 mb-0">                            
                                                        <input class="form-control" name="date2" type="date" placeholder=".">
                                                    </div>
                                            </div> 
                                        </div>               
                                    </div>
                                    <button class="btn btn-info" style='float:right;' type='submit' name='search'><i class="fa fa-search"></i> Rechercher</button>
                                </form>
                            </div>   
                        </div>
                        <?php
                            if (isset($_POST['search'])) {
                                extract($_POST);
                                global $data;
                                //1 - client + nature + type + createur + date 
                                if (!empty($client) && !empty($nature) &&  !empty($type) && !empty($createur) && !empty($date1) && !empty($date2)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client = :client AND nature=:nature AND ID_banque=:type AND createur=:createur AND date_creation BETWEEN :date1 AND :date2");
                                    $rq3->execute([
                                        'client' => $client,
                                        'nature' => $nature,
                                        'createur' => $createur,
                                        'date1' => $date1,
                                        'date2'=> $date2,
                                        'type'=> $type
                                    ]);
                                }
                                //2 - client + nature + type + createur
                                else if (!empty($client) && !empty($nature) &&  !empty($type) && !empty($createur) ){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client = :client AND nature=:nature AND ID_banque=:type AND createur=:createur");
                                    $rq3->execute([
                                        'client' => $client,
                                        'nature' => $nature,
                                        'createur' => $createur,
                                        'type' => $type
                                    ]);
                                }
                                
                                //3- client + nature + type + date 
                                else if (!empty($client) && !empty($nature) && !empty($date1) && !empty($type) && !empty($date2) ){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client = :client AND nature=:nature AND ID_banque=:type AND date_creation BETWEEN :date1 AND :date2");
                                    $rq3->execute([
                                        'client' => $client,
                                        'nature' => $nature,
                                        'date1' => $date1,
                                        'date2'=> $date2,
                                        'type' => $type
                                    ]);
                                }
                                //4- client + createur + type + date
                                else if (!empty($client) && !empty($createur) && !empty($date1) && !empty($type) && !empty($date2) ){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client = :client  AND createur=:createur AND ID_banque=:type AND date_creation BETWEEN :date1 AND :date2");
                                    $rq3->execute([
                                        'client' => $client,
                                        'createur' => $createur,
                                        'date1' => $date1,
                                        'date2'=> $date2,
                                        'type' => $type
                                    ]);
                                }

                                //5- nature + type + createur + date
                                else if (!empty($nature) && !empty($createur) && !empty($date1) && !empty($type) && !empty($date2) ){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE  nature=:nature AND createur=:createur AND ID_banque=:type AND date_creation BETWEEN :date1 AND :date2");
                                    $rq3->execute([
                                        'nature' => $nature,
                                        'createur' => $createur,
                                        'date1' => $date1,
                                        'date2'=> $date2,
                                        'type' => $type
                                    ]);
                                }
                                //6 - client + nature + date + createur
                                else if (!empty($nature) && !empty($createur) && !empty($date1) && !empty($client) && !empty($date2) ){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE  nature=:nature AND createur=:createur AND client=:client AND date_creation BETWEEN :date1 AND :date2");
                                    $rq3->execute([
                                        'nature' => $nature,
                                        'createur' => $createur,
                                        'date1' => $date1,
                                        'date2'=> $date2,
                                        'client' => $client
                                    ]);
                                }

                                //7- client + type + createur
                                else if (!empty($client) && !empty($createur) && !empty($type)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client = :client AND ID_banque=:type AND createur=:createur");
                                    $rq3->execute([
                                        'client' => $client,
                                        'createur' => $createur,
                                        'type' => $type
                                    ]);
                                }
                                
                                //8- client + date + type
                                else if (!empty($client) && !empty($type) &&  !empty($date1) && !empty($date2) ){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client = :client AND ID_banque=:type AND date_creation BETWEEN :date1 AND :date2");
                                    $rq3->execute([
                                        'client' => $client,
                                        'date1' => $date1,
                                        'date2'=> $date2,
                                        'type' => $type
                                    ]);
                                }

                                //9- client + nature + type
                                else if (!empty($client) && !empty($type) && !empty($nature)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client = :client AND ID_banque=:type AND nature=:nature");
                                    $rq3->execute([
                                        'client' => $client , 
                                        'nature' => $nature,
                                        'type' => $type
                                    ]);
                                }

                                //10- nature + createur + type
                                else if (!empty($nature) && !empty($type) &&  !empty($createur) ){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE nature = :nature AND ID_banque=:type AND createur = :createur");
                                    $rq3->execute([
                                        'nature' => $nature, 
                                        'createur' => $createur,
                                        'type' => $type
                                    ]);
                                }

                                //11- nature + date + type 
                                else if (!empty($nature) && !empty($type) &&  !empty($date1) && !empty($date2) ){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE nature = :nature AND ID_banque=:type AND date_creation BETWEEN :date1 AND :date2");
                                    $rq3->execute([
                                        'nature' => $nature,
                                        'date1' => $date1,
                                        'date2'=> $date2,
                                        'type' => $type
                                    ]);
                                }
                                //12- createur + date + type
                                else if (!empty($createur) && !empty($type) &&  !empty($date1) && !empty($date2) ){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE createur = :createur AND ID_banque=:type AND date_creation BETWEEN :date1 AND :date2");
                                    $rq3->execute([
                                        'createur' => $createur , 
                                        'date1' => $date1 , 
                                        'date2' => $date2,
                                        'type' => $type
                                    ]);
                                }

                                //13- client + nature + date
                                else if (!empty($client) && !empty($nature) &&  !empty($date1) && !empty($date2) ){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client = :client AND nature=:nature AND date_creation BETWEEN :date1 AND :date2");
                                    $rq3->execute([
                                        'client' => $client , 
                                        'date1' => $date1 , 
                                        'date2' => $date2,
                                        'nature' => $nature
                                    ]);
                                }

                                //15- client + date + createur
                                else if (!empty($client) && !empty($createur) &&  !empty($date1) && !empty($date2) ){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client = :client AND createur=:createur AND date_creation BETWEEN :date1 AND :date2");
                                    $rq3->execute([
                                        'client' => $client , 
                                        'date1' => $date1 , 
                                        'date2' => $date2,
                                        'createur' => $createur
                                    ]);
                                }

                                //16- nature + createur + date
                                else if (!empty($nature) && !empty($createur) &&  !empty($date1) && !empty($date2) ){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE nature = :nature AND createur=:createur AND date_creation BETWEEN :date1 AND :date2");
                                    $rq3->execute([
                                        'nature' => $nature , 
                                        'date1' => $date1 , 
                                        'date2' => $date2,
                                        'createur' => $createur
                                    ]);
                                }

                                //17- client + type
                                else if (!empty($client) && !empty($type)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client = :client AND ID_banque=:type");
                                    $rq3->execute(['client' => $client, 'type' => $type]);
                                }
                                
                                //18- nature + type
                                else if (!empty($nature) && !empty($type)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE nature = :nature AND ID_banque=:type");
                                    $rq3->execute(['nature' => $nature, 'type' => $type]);
                                }

                                //19- createur + type
                                else if (!empty($createur) && !empty($type)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE createur = :createur AND ID_banque=:type");
                                    $rq3->execute(['createur' => $createur, 'type' => $type]);
                                }

                                //20- date + type
                                else if (!empty($date1) && !empty($date2) && !empty($type)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE ID_banque=:type AND date_creation BETWEEN  :date1 AND :date2");
                                    $rq3->execute(['date1' => $date1 , 'date2' => $date2, 'type' => $type ]);
                                }
                                
                                //21- client + nature
                                else if (!empty($client) && !empty($nature)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client = :client AND nature=:nature");
                                    $rq3->execute(['client' => $client, 'nature' => $nature]);
                                }

                                //22- client + date
                                else if (!empty($date1) && !empty($date2) && !empty($client)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client=:client AND date_creation BETWEEN  :date1 AND :date2");
                                    $rq3->execute(['date1' => $date1 , 'date2' => $date2, 'client' => $client ]);
                                }

                                //23- client + createur
                                else if (!empty($client) && !empty($createur)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client = :client AND createur=:createur");
                                    $rq3->execute(['client' => $client, 'createur' => $createur]);
                                }

                                //24- nature + createur
                                else if (!empty($nature) && !empty($createur)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE nature = :nature AND createur=:createur");
                                    $rq3->execute(['nature' => $nature, 'createur' => $createur]);
                                }

                                //25- date + nature
                                else if (!empty($date1) && !empty($date2) && !empty($nature)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE nature=:nature AND date_creation BETWEEN  :date1 AND :date2");
                                    $rq3->execute(['date1' => $date1 , 'date2' => $date2, 'nature' => $nature ]);
                                }

                                //26- date + createur
                                else if (!empty($date1) && !empty($date2) && !empty($createur)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE createur=:createur AND date_creation BETWEEN  :date1 AND :date2");
                                    $rq3->execute(['date1' => $date1 , 'date2' => $date2, 'createur' => $createur ]);
                                }

                                //27- date
                                else if (!empty($date1) && !empty($date2)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE  date_creation BETWEEN  :date1 AND :date2");
                                    $rq3->execute(['date1' => $date1 , 'date2' => $date2 ]);
                                }

                                //28- createur
                                else if (!empty($createur)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE createur=:createur");
                                    $rq3->execute(['createur' => $createur ]);
                                }

                                //29- nature
                                else if (!empty($nature)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE nature=:nature");
                                    $rq3->execute(['nature' => $nature ]);
                                }

                                //30- type
                                else if (!empty($type)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE ID_banque=:type");
                                    $rq3->execute(['type' => $type ]);
                                }

                                //30- client
                                else if (!empty($client)){
                                    $rq3 = $data->prepare("SELECT * FROM facture WHERE client=:client");
                                    $rq3->execute(['client' => $client ]);  
                                }
                                if (!empty($rq3)) $length=$rq3->rowCount();
                        ?>

                        <b>Résultats de la recherche : <?php  if ($length==1)echo ' une seule facture'; else echo $length.' factures'; ?></b>
                        <?php if ($length>0){?>
                        <link href="css/cartes.css" rel="stylesheet" />
                        <div class="container">
                            <?php $i=1; while ($ligne = $rq3 -> fetch()) { ?>
                            <div class="card">
                                <div class="box">
                                    <div class="content">
                                        <h2><?php if ($i<10) echo '0'.$i; else echo $i;?></h2>
                                        <h3><?php echo $ligne['numero'];?></h3>
                                        <p>
                                        <I><b><?php echo $ligne['client'];?> </I></b><br> 
                                        
                                        Objet : <?php echo $ligne['objet'];?> <br>
                                        Montant <b> <?php echo number_format($ligne['prix_total'], 2, ',', ' ');?> DHS</b><br> 
                                        Crée le  <?php echo date('d/m/Y', strtotime($ligne['date_creation']));?> 
                                        </p>  
                                        <a type='button' target="_blank" href="/e-facture/viewFacture.php?id=<?php echo $ligne['ID'];?>">Facture <?php echo $ligne['nature'];?></a>
                                    </div>
                                </div>
                            </div>
                            <?php $i++;}?>
                        </div>
                        <?php }}?>
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
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
