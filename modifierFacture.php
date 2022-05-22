<?php //  si l'utulisateur est non connecté alors bloquer la page de notifications 
    if (session_status()==PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['ID'])) header('Location: /e-facture/login.php');
    
    include 'Database.php';
    global $data;

    $rq = $data->prepare("SELECT * FROM utilisateurs WHERE ID = :ID");
    $rq->execute(['ID' => $_SESSION['ID']]);
    $result=$rq->fetch();
    if ($result['role']!='administrateur') header('Location: /e-facture/404.php');


    if (isset($_GET['id']) && $_GET['id']>0){ 
        $id= intval($_GET['id']); // securité : empecher l'utulisateur a editer du texte en url
        $rq0 = $data->prepare("SELECT * FROM facture WHERE ID = :ID");
        $rq0->execute(['ID' => $id]);
        $test=$rq0->rowCount();
        if ($test==0) header('Location: /e-facture/404.php');
        $result0=$rq0->fetch();

        $rq1 = $data->prepare("SELECT * FROM designation WHERE ID_facture = :ID");
        $rq1->execute(['ID' => $id]);
        $length=$rq1->rowCount();
        if ($length==1)$result1=$rq1->fetch(); // cas de facture test performences et formation

    }else header('Location: /e-facture/404.php');
    $message='';

    $rq2 = $data->prepare("SELECT * FROM banque");
    $rq2->execute();

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
        <title>Modifier une facture</title>
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
                    <h1 class="mt-4"><i class="fa fa-edit"></i> Modification de la facture <b class='text-success'> <?php echo $result0['numero']; ?></b></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item "><a class='text-success' href="dashboard.php">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Gestion des factures</li>
                        </ol>

                        <div class="card mb-0 border-white">
                            <div class="card-body">
                                <form class="needs-validation" novalidate action='' method='post'>
                                    <div class="form-row">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <div class="form-floating mb-2 ">
                                                    <input class="form-control " name="numero" type="text" value="<?php echo $result0['numero']; ?>" placeholder="." required>
                                                    <label for="numero">Numéro de la facture </label>
                                                    <div class="invalid-tooltip">Champs obligatoire</div> 
                                                </div>
                                            </div>
                                            <div class="form-floating col-md-4 mb-2">
                                                <select class="form-select shadow-success" name="nature" placeholder="." required>
                                                    <option value='formation' <?php if ($result0['nature']=='formation') echo 'selected'?>>Facture formation</option>
                                                    <option value='test performances' <?php if ($result0['nature']=='test performances') echo 'selected'?> >Facture études et tests de performances</option>
                                                </select>
                                                <label for="createur" style='margin: 0px  12px;'>Nature de facture</label>
                                                <div class="invalid-tooltip">Champs obligatoire</div> 
                                            </div>

                                            <div class="form-floating col-md-4 mb-2">
                                                <select class="form-select shadow-success" name="banque" placeholder="." required>
                                                    <option value=''>....</option>
                                                    <?php while($ligne=$rq2->fetch()) { ?>
                                                    <option value='<?php echo $ligne['ID'];?>' <?php if ($ligne['ID']==$result0['ID_banque']) echo 'selected';?> > <?php echo $ligne['agence'].' ['.$ligne['nature'].']'; ?></option>
                                                    <?php } ?>
                                                    </select>
                                                <label for="banque" style='margin: 0px  11px;'>Banque</label>
                                                <div class="invalid-feedback">Vous devez choisir une réponse</div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" name="client" type="text" value="<?php echo $result0['client']; ?>"  placeholder="." required/>
                                                    <label for="client">Client </label>
                                                    <div class="invalid-tooltip">Champs obligatoire</div> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" name="objet" type="text" value="<?php echo $result0['objet']; ?>" placeholder="." required/>
                                                    <label for="objet">Objet de la facture</label>
                                                    <div class="invalid-tooltip">Champs obligatoire</div> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-9">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="obs" rows="8" placeholder="observations " ><?php echo $result0['observations']; ?></textarea>
                                                    <label for="obs">Observations</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-floating">
                                                    <input class="form-control " name="ice" type="text" value="<?php echo $result0['ICE']; ?>" placeholder="." >
                                                    <label for="ice">ICE </label>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if( $result0['nature']=='formation' && $length==1 ){?> <!-- facture formation -->
                                            
                                        <div class="form-floating mb-3">    
                                            <textarea class="form-control" name="designation" rows="8"  placeholder="designation " required><?php echo $result1['designation'];?></textarea>
                                            <label for="designation">Designation</label>
                                            <div class="invalid-tooltip">Champs obligatoire</div> 
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control " name="quantite" type="number" value='<?php echo $result1['quantite']; ?>' placeholder="1" required>
                                                    <label for="quantite">Nombres de personnes </label>
                                                    <div class="invalid-tooltip">Valeur non nulle !</div> 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input class="form-control" name="prix" type="number" step="0.01" min='1' value='<?php echo $result1['prix']; ?>' placeholder="1" required/>
                                                    <label for="prix">Prix unitaire </label>
                                                    <div class="invalid-tooltip">Valeur non nulle !</div> 
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input class="form-control" name="jours" type="number" value='<?php  echo str_replace('T', "",$result1['jours']); ?>' placeholder="1"/>
                                                    <label for="jours">Nombre de jours </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-check">
                                            <input class="form-check-input" name="verifyJours" type="checkbox" value="oui" <?php if ($result1['jours'][strlen($result1['jours'])-1]=='T') echo 'checked'?> />
                                            <label class="form-check-label" for="verifyJours" >Afficher le nombre de jours dans la facture</label>
                                        </div>


                                        <?php } else if( $result0['nature']=='test performances' && $length==1){?> <!-- facture test de performances -->

                                        <div class="row mb-1">
                                            <div class="col-md-10">
                                                <div class="form-floating mb-3">    
                                                    <textarea class="form-control" name="designation" rows="8"  placeholder="designation " required><?php echo $result1['designation']; ?></textarea>
                                                    <label for="designation">Designation</label>
                                                    <div class="invalid-tooltip">Champs obligatoire</div> 
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <div class="form-floating">
                                                    <input class="form-control" name="prix" type="number" step="0.01" min='1' value='<?php echo $result1['prix']; ?>' placeholder="1" required/>
                                                    <label for="prix">Prix total </label>
                                                    <div class="invalid-tooltip">Valeur non nulle !</div> 
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php } else if( $result0['nature']=='formation' &&  $length>1 ){?> <!-- facture formation avec sessions-->

                                        <?php 
                                        global $data;
                                        $rq3 = $data->prepare("SELECT * FROM designation WHERE ID_facture = :ID AND prix=0 AND quantite=0");
                                        $rq3->execute(['ID' => $id]); 
                                        $desi=$rq3->fetch();
                                        $count=$rq3->rowCount(); ?>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" name="designation" rows="8"  placeholder="designation" required><?php if($count!=0) echo $desi['designation']; else echo "!!! Problème au niveau de la base de données, veuillez contacter l'équipe IT"; ?></textarea>
                                            <label for="designation">Designation</label>
                                            <div class="invalid-tooltip">Champs obligatoire</div> 
                                        </div>

                                        <table class="table">
                                            <thead class='thead-dark'>
                                                <tr>
                                                    <th scope="col" class='col-6' style='text-align:center'>Opérations</th>
                                                    <th scope="col" class='col-1' style='text-align:center'>PU/Session</th>
                                                    <th scope="col" class='col-1' style='text-align:center'>Nbr sessions</th>
                                                    <th scope="col" class='col-1 text-danger' style='text-align:center'><i class="fa fa-trash-alt"></i> Supprimer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $p=1; 
                                                $rq4 = $data->prepare("SELECT * FROM designation WHERE ID_facture = :ID AND prix>0 AND quantite>0");
                                                $rq4->execute(['ID' => $id]); 
                                                
                                                while ( $ligne = $rq4 -> fetch() ) { 
                                                if ($p==1){ ?>

                                                <tr class='border-dark'>
                                                    <td>
                                                        <textarea class="form-control" name="op[]" rows="1" placeholder="Opération 1" required><?php echo $ligne['designation']; ?></textarea>
                                                        <div class="invalid-feedback">Vous devez éditer au moins une opération pour valider la facture</div>
                                                    </td>
                                                    <td>        
                                                        <input class="form-control" name="prix[]" type="number" step="0.01" min='1' value='<?php echo $ligne['prix']; ?>' required>
                                                        <div class="invalid-feedback">Champs obligatoire</div>       
                                                    </td>
                                                            
                                                    <td>
                                                        <input class="form-control" name="quantite[]" type="number" min='1' value='<?php echo $ligne['quantite']; ?>' required>
                                                        <div class="invalid-feedback">Champs obligatoire</div> 
                                                    </td>

                                                    <td >
                                                        <div class="form-check" >
                                                            <input class="form-check-input" name="supprimer[]" type="checkbox" value='<?php echo $ligne['ID']; ?>' style="width:30px; height:30px; margin: 5px 24px;"/>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <?php }else{?>
                                                <tr class='border-dark'>
                                                    <td><textarea class="form-control" name="op[]" rows="1" placeholder="Opération 1" ><?php echo $ligne['designation']; ?></textarea></td>
                                                    <td><input class="form-control" name="prix[]" type="number" step="0.01" min='1' value='<?php echo $ligne['prix']; ?>' ></td>
                                                    <td><input class="form-control" name="quantite[]" type="number" min='1' value='<?php echo $ligne['quantite']; ?>' ></td>
                                                    <td >
                                                        <div class="form-check" >
                                                            <input class="form-check-input" name="supprimer[]" value='<?php echo $ligne['ID']; ?>' type="checkbox" style="width:30px; height:30px; margin: 5px 24px;"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                                <?php } $p++; } ?>  

                                                <tr class='border-dark'>
                                                    <td><textarea class="form-control" name="newop[]" rows="1" placeholder="Opération " ></textarea></td>
                                                    <td><input class="form-control" name="newprix[]" type="number" step="0.01" min='1' ></td>                                                            
                                                    <td><input class="form-control" name="newquantite[]" type="number" min='1'></td>
                                                </tr>  

                                                <tr class='border-dark'>
                                                    <td><textarea class="form-control" name="newop[]" rows="1" placeholder="Opération " ></textarea></td>
                                                    <td><input class="form-control" name="newprix[]" type="number" step="0.01" min='1' ></td>                                                            
                                                    <td><input class="form-control" name="newquantite[]" type="number" min='1' ></td>
                                                </tr> 
                                                        
                                                <tr class='border-dark'>
                                                    <td><textarea class="form-control" name="newop[]" rows="1" placeholder="Opération " ></textarea></td>
                                                    <td><input class="form-control" name="newprix[]" type="number" step="0.01" min='1'></td>                                                            
                                                    <td><input class="form-control" name="newquantite[]" type="number" min='1' ></td>
                                                </tr>

                                                <tr class='border-dark'>
                                                    <td><textarea class="form-control" name="newop[]" rows="1" placeholder="Opération " ></textarea></td>
                                                    <td><input class="form-control" name="newprix[]" type="number" step="0.01" min='1'></td>                                                            
                                                    <td><input class="form-control" name="newquantite[]" type="number" min='1' ></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <?php }
                                        if($countLibelle!=0){
                                            $i=1;
                                            while($libelle=$libellesFacture->fetch()){ ?>

                                                <div class="row mb-3">        
                                                    <div class="col-md-9">
                                                        <div class="form-floating">
                                                            <textarea class="form-control" name="libelle[]" rows="8" placeholder="." required><?php echo $libelle['libelle']; ?></textarea>
                                                            <label for="libelle[]">Libellé <?php echo $i;?></label>
                                                            <div class="invalid-feedback">Champs obligatoire</div> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-floating">
                                                            <input class="form-control" name="prixLibelle[]" type="number" placeholder="1" step="0.01" min='1' value='<?php echo $libelle['prix']; ?>' required/>
                                                            <label for="prixLibelle[]">Montant du libellé <?php echo $i;?></label>
                                                            <div class="invalid-feedback">Montant invalid</div> 
                                                        </div>
                                                    </div>
                                                </div>
                                        
                                        <?php $i++; }}
                                        $rq = $data->prepare("SELECT * FROM banque WHERE ID=:ID");
                                        $rq->execute([ 'ID' => $result0['ID_banque']]);
                                        $bank=$rq->fetch();
                                        if ($bank['nature']=='nationale'){?>
                                        <div class='row'>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input class="form-control" name="devise" type="text" value='<?php echo $result0['devise']; ?>' placeholder="1" />
                                                    <label for="devise">Devise </label>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card ">
                                                    <div class="card-body text-danger">
                                                    <i class="fa fa-info-circle fa-lg"> </i> Si vous souhaitez utiliser <b>MAD</b> alors vous pouvez laisser la case <b>DEVISE</b> vide.
                                                    </div>
                                                </div>
                                        </div>
                                        </div>

                                        <?php }?>
                                        
                                    </div>
                                    
                            </div>
                        </div>

                        <?php
                        $exam=0; $error='';  $somme=0;

                        if (isset($_POST['update'])) {
                            extract($_POST);
                            global $data;

                            if (!empty($nature) && $nature != $result0['nature']){
                                $rq = $data->prepare("UPDATE facture  SET nature=:nature WHERE ID=:ID");
                                $rq->execute(['ID' => $id, 'nature'=> $nature]);
                                $exam=1;
                            }

                            if (!empty($client) && $client != $result0['client']){
                                $rq = $data->prepare("UPDATE facture  SET client=:client WHERE ID=:ID");
                                $rq->execute(['ID' => $id, 'client'=> $client]);
                                $exam=1;
                            }

                            if (!empty($objet) && $objet != $result0['objet']){
                                $rq = $data->prepare("UPDATE facture  SET objet=:objet WHERE ID=:ID");
                                $rq->execute(['ID' => $id, 'objet'=> $objet]);
                                $exam=1;
                            }

                            if (!empty($obs) && $obs != $result0['observations']){
                                $rq = $data->prepare("UPDATE facture  SET obs=:obs WHERE ID=:ID");
                                $rq->execute(['ID' => $id, 'obs'=> $obs]);
                                $exam=1;
                            }

                            if (!empty($ice) && $ice != $result0['ICE']){
                                $rq = $data->prepare("UPDATE facture  SET ICE=:ICE WHERE ID=:ID");
                                $rq->execute(['ID' => $id, 'ICE'=> $ice]);
                                $exam=1;
                            }

                            if (!empty($devise) && $devise != $result0['devise']){
                                $devise=strtoupper($devise);
                                $rq = $data->prepare("UPDATE facture  SET devise=:devise WHERE ID=:ID");
                                $rq->execute(['ID' => $id, 'devise'=> $devise]);
                                $exam=1;
                            }
                            if (!empty($numero) && $numero != $result0['numero']){
                                $numero = str_replace(' ', '', $numero);
                                $numero=strtoupper($numero);
                                $rq = $data->prepare("SELECT numero FROM facture WHERE numero = :numero");
                                $rq->execute(['numero' => $numero]);
                                $length= $rq->rowCount();
                                if ($length==0){
                                    $rq = $data->prepare("UPDATE facture  SET numero=:numero WHERE ID=:ID");
                                    $rq->execute(['ID' => $id, 'numero'=> $numero]);
                                    $exam=1;
                                }else $error.='Ce numéro de facture existe déjà, vous ne pouvez pas avoir deux factures de même numéro.';
                            }

                            if ($result0['nature']=='test performances' && $length==1 ){ // facture performances avec une seule designation

                                if (!empty($designation) && $designation != $result1['designation'] ){
                                    $rq= $data->prepare('UPDATE designation  SET designation=:ope WHERE ID=:ID');
                                    $rq->execute([ 'ope'=>$designation , 'ID'=>$result1['ID'] ]);
                                    $exam=1;
                                }

                                if (!empty($prix) && $prix != $result1['prix'] ){
                                    $rq= $data->prepare('UPDATE designation  SET prix=:prix WHERE ID=:ID');
                                    $rq->execute([ 'prix'=>$prix , 'ID'=>$result1['ID'] ]);
                                    $exam=1;
                                }   

                                $somme+=$prix; 

                            }else if ($result0['nature']=='formation' && $length==1 ){ // facture formation avec une seule designation

                                if (!empty($designation) && $designation != $result1['designation'] ){
                                    $rq= $data->prepare('UPDATE designation  SET designation=:ope WHERE ID=:ID');
                                    $rq->execute([ 'ope'=>$designation , 'ID'=>$result1['ID'] ]);
                                    $exam=1;
                                }                  

                                if (!empty($prix) && $prix != $result1['prix'] ){
                                    $rq= $data->prepare('UPDATE designation  SET prix=:prix WHERE ID=:ID');
                                    $rq->execute([ 'prix'=>$prix , 'ID'=>$result1['ID'] ]);
                                    $exam=1;
                                }   

                                if (!empty($quantite) && $quantite != $result1['quantite'] ){
                                    $rq= $data->prepare('UPDATE designation  SET quantite=:quantite WHERE ID=:ID');
                                    $rq->execute([ 'quantite'=>$quantite , 'ID'=>$result1['ID'] ]);
                                    $exam=1;
                                }   

                                if (!empty($jours) && $jours != $result1['jours'] ){
                                    $rq= $data->prepare('UPDATE designation  SET jours=:jours WHERE ID=:ID');
                                    $rq->execute([ 'jours'=>$jours , 'ID'=>$result1['ID'] ]);
                                    $exam=1;
                                }   

                                if (!empty($jours) && !empty($verifyJours) ){
                                    
                                    $rq4 = $data->prepare("UPDATE designation  SET jours=:jours WHERE ID=:ID");
                                    $rq4->execute(['jours' => $jours.'T', 'ID'=> $result1['ID'] ]);                
                                    $exam=1;
                                }  

                                if (!empty($jours)) $somme+=$jours*$quantite*$prix; 

                            } elseif ($result0['nature']=='formation' && $length>1 ){ // facture formation avec plusieurs sessions
                                            
                                $i=0; $count=1; $tester=0;

                                $rq4 = $data->prepare("SELECT * FROM designation WHERE ID_facture = :ID AND prix>0 AND quantite>0");
                                $rq4->execute(['ID' => $id]); 

                                while ( $ligne = $rq4 -> fetch() ) {
                                    if (!empty($op[$i]) && $op[$i]!=$ligne['designation']){
                                        $rq= $data->prepare('UPDATE designation  SET designation=:ope WHERE ID=:ID');
                                        $rq->execute([ 'ope'=>$op[$i] , 'ID'=>$ligne['ID']]);
                                        $exam=1;

                                    } 
                                    if (!empty($prix[$i]) && $prix[$i]!=$ligne['prix']){
                                        $rq= $data->prepare('UPDATE designation  SET prix=:prix WHERE ID=:ID');
                                        $rq->execute([ 'prix'=>$prix[$i] , 'ID'=>$ligne['ID']]);
                                        $exam=1;
                                                
                                    }
                                    if (!empty($quantite[$i]) && $quantite[$i]!=$ligne['quantite'] ){
                                        $rq= $data->prepare('UPDATE designation  SET quantite=:quantite WHERE ID=:ID');
                                        $rq->execute([ 'quantite'=>$quantite[$i] , 'ID'=>$ligne['ID'] ]);
                                        $exam=1;
                                    }

                                    if (!empty($supprimer[$i]) && $count<$length-1){
                                        $rq3 = $data->prepare("DELETE FROM designation WHERE ID=:ID");
                                        $rq3->execute([ 'ID' => $supprimer[$i] ]);
                                        $exam=1; $count++;
                                    }

                                    if (!empty($supprimer[$i]) && $count==$length-1 && $tester==0){
                                        $error.='Vous ne pouvez pas supprimer toutes les opérations. La facture doit contenir au moins une opération.';
                                        $tester=1;
                                    }
                                    $somme+=$quantite[$i]*$prix[$i];
                                    $i++;
                                }
                        
                                for ($p=0;$p<3;$p++){
                                    if (!empty($newop[$p]) && !empty($newprix[$p]) && !empty($newquantite[$p])){
                                        $rq= $data->prepare('INSERT INTO designation(ID_facture,designation,prix,quantite) VALUES(:ID_facture,:designation,:prix,:quantite)');
                                        $rq->execute([
                                            'ID_facture'=>$id,
                                            'designation'=>$newop[$p],
                                            'prix'=> $newprix[$p],
                                            'quantite'=>$newquantite[$p]
                                            ]);
                                        $exam=1;
                                    }
                                }
                            }
                            if ($countLibelle!=0){
                                $p=0;
                                $libellesFacture = $data->prepare("SELECT * FROM libellesFacture WHERE ID_facture = :ID");
                                $libellesFacture->execute(['ID' => $_SESSION['IDfacture']]);

                                while( $result=$libellesFacture->fetch() ){

                                    if(!empty($libelle[$p]) && $libelle[$p]!=$result['libelle']){
                                        $rq= $data->prepare('UPDATE libellesFacture  SET libelle=:libelle WHERE ID=:ID');
                                        $rq->execute([ 
                                            'libelle'=>$libelle[$p],
                                            'ID'=>$result['ID']
                                        ]);
                                        $exam=1;
                                    }
                                    
                                    if(!empty($prixLibelle[$p]) && $prixLibelle[$p]!=$result['prix']){
                                        $rq= $data->prepare('UPDATE libellesFacture  SET prix=:prix WHERE ID=:ID');
                                        $rq->execute([ 
                                            'prix'=>$prixLibelle[$p],
                                            'ID'=>$result['ID']
                                        ]);
                                        $exam=1;
                                    }
                                    $p++;
                                }  
                            }

                            $rq= $data->prepare('UPDATE facture  SET prix_total=:prix WHERE ID=:ID');
                            $rq->execute([ 'prix'=>$somme , 'ID'=>$id ]);

                            if ($exam==1 && empty($error)){
                                ?> <script> 
                                    window.location.assign("/e-facture/modifierFacture.php?id="+$id); 
                                </script><?php
                            }

                        }
                        if (!empty($error)){?>

                            <div class='col-md-9'>
                                <div class="h-75 card  alert alert-danger" role="alert" style='margin: 0px 0px;'>
                                    <div class="row  ">
                                        <div class='col-md-11' style='margin: -10px  0px;'><i class="fa fa-exclamation-triangle "></i> <b><?php echo $error;?></b></div>
                                        <div class='col-md-1' style='margin: -9px 0px;'>
                                            <button type="button" class="btn-close btn-danger" data-bs-dismiss="alert" aria-label="Close" ></button>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <br>
                        <?php } $error='';?>
                        
                        <div style='margin: 5px 19px'>
                            <button type='submit' class="btn btn-primary" name='update' ><i class="fa fa-save"></i> enregistrer</button>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#supprimer"><i class="fa fa-trash-alt"></i> supprimer</button>
                            <button type="button" class="btn btn-info" onclick="window.location.href='/e-facture/print.php?id='+<?php echo $id;?>" ><i class="fa fa-print"></i> imprimer</button>
                            <br><br>
                        </div>
                        </form>

                        <div class="modal fade" id="supprimer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h5 class="modal-title text-white" id="staticBackdropLabel"><i class="fa fa-exclamation-triangle fa-2x"></i> Attention</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form class="needs-validation" novalidate action='' method='post'>
                                        <div class="modal-body">
                                            <b>Voulez-vous vraiment supprimer la facture <?php echo $result0['numero'];?>? </b>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-block" data-bs-dismiss="modal"><i class="fa fa-times"></i> NON</button>
                                            <button type="submit" name='delete' class="btn btn-success btn-block"><i class="fa fa-check"></i>  OUI</button>
                                        </div>
                                    </form>
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
?>
