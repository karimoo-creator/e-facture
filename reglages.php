<?php //  si l'utulisateur est non connecté alors bloquer la page de notifications 
    if (session_status()==PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['ID'])) header('Location: /e-facture/login.php');

    include 'Database.php';
    global $data;
    $rq = $data->prepare("SELECT * FROM utilisateurs WHERE ID = :ID");
    $rq->execute(['ID' => $_SESSION['ID']]);
    $result=$rq->fetch();

    $rq2 = $data->prepare("SELECT * FROM banque");
    $rq2->execute();

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
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="width:16px; float:right; height:30px; margin: 0px  6px;"></i></button>
            <!--  <a class="navbar-brand ps-3" href="index.html">E-facture</a> -->
            <img src="facture.png" class="navbar-brand ps-3" alt="img-thumbnail" style="width: 200px; text-align: center; margin: 0px  -16px;">
            
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $result['prenom'].' '.$result['nom']; ?> <i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu  dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item " href="reglages.php">Réglages</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item " href="deconnexion.php">Deconnexion</a></li>
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
                            
                            <a class="nav-link text-success" href="etape1.php">
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
                            
                            <?php if ($result['role']=='administrateur'){?>
                            <div class="sb-sidenav-menu-heading">Divers</div>
                            <a class="nav-link text-success" href="users.php">
                                <div class="sb-nav-link-icon text-success"><i class="fas fa-users"></i></div>
                                Gestion des rôles
                            </a>
                            <?php }?>
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
                        <h1 class="mt-4"><i class="fa fa-users-cog"></i> Réglages</h1>
                        <ol class="breadcrumb mb-4">
                        </ol>

                        <form action='' method='POST'>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-success">
                                            <i class="fas fa-user me-1 text-white"></i>
                                            <b class='text-white'>Informations personnelles</b>    
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-1">
                                                <p class=" col-md-6  mb-0"> Nom : <b class='text-success'> <?php echo $result['nom']; ?></b></p>
                                                <button id='change1' style="width:25px; height:25px;" type="button" class="btn btn-success col-md-1 mb-0"><i class="fa fa-edit" style="width:16px; float:right; height:16px; margin: -3px  -9px;" ></i></button>
                                                
                                                <div id='rep1' class="form-floating col-md-5 mb-1 ">
                                                    <input class="form-control " name="nom" type="text" placeholder="1" style='width:236px;  height:8px; margin: -4px  2px;'>
                                                    <label for="nom" style='font-size:15px; margin: -14px  13.5px;'> Nouveau nom </label>
                                                
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <p class=" col-md-6  mb-0"> Prénom : <b class='text-success'> <?php echo $result['prenom']; ?></b></p>
                                                <button id='change2' style="width:25px; height:25px;" type="button" class="btn btn-success col-md-3 mb-0"><i class="fa fa-edit" style="width:16px; float:right; height:16px; margin: -3px  -9px;" ></i></button>
                                                
                                                <div id='rep2' class="form-floating col-md-5 mb-1">
                                                    <input class="form-control " name="prenom" type="text" placeholder="1" style='width:236px;  height:8px; margin: -4px  2px;'>
                                                    <label for="prenom" style='font-size:15px; margin: -14px  13.5px;'> Nouveau prénom </label>
                                                    
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <p class=" col-md-6  mb-0"> Numéro CNIE : <b class='text-success'> <?php echo $result['cin']; ?></b></p>
                                                <button id='change3' style="width:25px; height:25px;" type="button" class="btn btn-success col-md-3 mb-0"><i class="fa fa-edit" style="width:16px; float:right; height:16px; margin: -3px  -9px;" ></i></button>
                                            
                                                <div id='rep3' class="form-floating col-md-5 mb-1 mb-md-0">
                                                    <input class="form-control " name="cin" type="text" placeholder="1" style='width:236px;  height:8px; margin: -4px  2px;'>
                                                    <label for="cin" style='font-size:15px; margin: -14px  13.5px;'> Nouvelle CNIE </label>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="card mb-0 ">
                                        <div class="card-header  bg-success ">
                                            <i class="fas fa-at me-1 text-white"></i>
                                            <b class='text-white'>Informations du compte</b>
                                        </div>
                                        <div class="card-body">
                                            <p class=" mb-0"> Rôle plateforme : <b class='text-success'> <?php echo $result['role']; ?></b></p>                                            
                                            <div class="row mb-1">
                                                <p class=" col-md-6  mb-0"> Email : <b class='text-success'> <?php echo $result['email']; ?></b></p>
                                                <button id='change5' style="width:25px; height:25px;" type="button" class="btn btn-success col-md-3 mb-0"><i class="fa fa-edit" style="width:16px; float:right; height:16px; margin: -3px  -9px;" ></i></button>
                                                
                                                <div id='rep5' class="form-floating col-md-5 mb-1">
                                                    <input class="form-control " name="email" type="email" placeholder="1" style='width:236px;  height:8px; margin: -4px  2px;'>
                                                    <label for="email" style='font-size:15px; margin: -14px  13.5px;'> Nouveau email </label>
                                                </div>
                                            </div>

                                            <div class="row mb-1">
                                                <p class=" col-md-6  mb-0"> Fonction : <b class='text-success'> <?php echo $result['fonction']; ?></b></p>
                                                <button id='change4' style="width:25px; height:25px;" type="button" class="btn btn-success col-md-3 mb-0"><i class="fa fa-edit" style="width:16px; float:right; height:16px; margin: -3px  -9px;" ></i></button>
                                                
                                                <div id='rep4' class="form-floating col-md-5 mb-1 mb-md-0">
                                                    <input class="form-control " name="fonction" type="text" placeholder="1" style='width:236px;  height:8px; margin: -4px  2px;'>
                                                    <label for="fonction" style='font-size:15px; margin: -14px  13.5px;'> Nouvelle fonction </label>
                                                </div>
                                            </div>

                                            <button id="togg" type="button" class="btn btn-outline-success btn-sm ">Changer le mot de passe</button>
                                            <div id='toggRep'>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-floating">
                                                            <input class="form-control " id='pass1' name="oldpass" type="password" placeholder=".">
                                                            <label for="oldpass">Ancien mot de passe</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating">
                                                            <input class="form-control " id='pass2' name="newpass" type="password" placeholder="." >
                                                            <label for="newpass">Nouveau mot de passe</label>
                                                        </div>
                                                    </div>
                                                    <button type="button" class='col-md-1 btn btn-light' style='width:16px; height:25px margin: 0px  0px;' id="eye"><i class="fa fa-eye" style="width:16px; float:right; margin: -2px  -8px;" ></i></button>

                                                </div>
                                            </div>
                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row mb-0'>
                                <div class='col-md-3'>
                                    <button class="btn btn-success btn-sm " style="float:left;" type='submit' name='update'><i class="fa fa-save"></i> Enregistrer les modifications</button>
                                </div>
                        </form>
                        
                        <?php 
                            $exam=0; $error='';
                            if (isset($_POST['update'])) {
                                extract($_POST);
                                global $data;
                                if (!empty($nom)){
                                    $rq = $data->prepare("UPDATE utilisateurs  SET nom=:nom WHERE ID=:ID");
                                    $rq->execute(['ID' => $_SESSION['ID'], 'nom'=> $nom]);
                                    $exam=1;
                                }

                                if (!empty($prenom)){
                                    $rq = $data->prepare("UPDATE utilisateurs  SET prenom=:prenom WHERE ID=:ID");
                                    $rq->execute(['ID' => $_SESSION['ID'], 'prenom'=> $prenom]);
                                    $exam=1;
                                }

                                if (!empty($cin)){
                                    $cin = str_replace(' ', '', $cin);
                                    $cin=strtoupper($cin);
                                    $rq = $data->prepare("SELECT cin FROM utilisateurs WHERE cin = :cin");
                                    $rq->execute(['cin' => $cin]);
                                    $length= $rq->rowCount();
                                    if ($length==0){
                                        $rq = $data->prepare("UPDATE utilisateurs  SET cin=:cin WHERE ID=:ID");
                                        $rq->execute(['ID' => $_SESSION['ID'], 'cin'=> $cin]);
                                        $exam=1;
                                    }else $error='Ce numéro CNIE existe déjà';

                                }

                                if (!empty($email)){
                                    $email = str_replace(' ', '', $email);
                                    $rq = $data->prepare("SELECT email FROM utilisateurs WHERE email = :email");
                                    $rq->execute(['email' => $email]);
                                    $length= $rq->rowCount();
                                    if ($length==0){
                                        $rq = $data->prepare("UPDATE utilisateurs  SET email=:email WHERE ID=:ID");
                                        $rq->execute(['ID' => $_SESSION['ID'], 'email'=> $email]);
                                        $exam=1;
                                    }else $error='Cette adresse email existe déjà';
                                }

                                if (!empty($oldpass) && !empty($newpass)){
                                    $rq = $data->prepare("SELECT * FROM utilisateurs WHERE ID = :ID");
                                    $rq->execute(['ID' => $_SESSION['ID']]);
                                    $result= $rq->fetch();

                                    if (password_verify($oldpass,$result['password'])) {
                                        $configuration = ['cost' => 12];
                                        $hachpass = password_hash($newpass, PASSWORD_BCRYPT, $configuration);
                                        if (!password_verify($newpass,$hachpass)) {echo $error='décryptage de mot de passe échoué';  exit(); }

                                        $rq = $data->prepare("UPDATE utilisateurs  SET password=:pass WHERE ID=:ID");
                                        $rq->execute([
                                            'pass' => $hachpass , 
                                            'ID' => $_SESSION['ID']
                                        ]);            
                                    }else $error='Mot de passe incorrect';
                                    $exam=1;
                                }

                                if ($exam==1 && empty($error)){?>
                            <div class='col-md-6'>
                                <div class="h-25 card  alert alert-info" role="alert" style='margin: -2px  -35px;'>
                                    <div class="row  ">
                                        <div class='col-md-11' style='margin: -12px  0px;'><i class="fa fa-check-circle fa-lg"></i> Vos modifications sont bien enregistrées.</div>
                                        <div class='col-md-1' style='margin: -12px 0px;'>
                                            <button type="button" class="btn-close btn-info" data-bs-dismiss="alert" aria-label="Close" ></button>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        <?php }else if (!empty($error)){ ?>

                            <div class='col-md-3'>
                                <div class="h-25 card  alert alert-danger" role="alert" style='margin: -2px  -35px;'>
                                    <div class="row  ">
                                        <div class='col-md-11' style='margin: -12px  0px;'><i class="fa fa-exclamation-triangle "></i> <b><?php echo $error;?></b></div>
                                        <div class='col-md-1' style='margin: -12px -6px;'>
                                            <button type="button" class="btn-close btn-danger" data-bs-dismiss="alert" aria-label="Close" ></button>
                                        </div>
                                    </div>
                                </div>
                            </div>  

                        <?php }} ?>
                    </div>
                        <br>
                        <?php if($result['role']=='administrateur') {?>
                            <div class="card mb-4">
                                <div class="card-header bg-success">
                                    <i class="fas fa-coins me-1 text-white"></i>
                                    <b class='text-white'>Ajouter une banque</b>
                                    
                                </div>
                                <div class="card-body">
                                    <form class="needs-validation" novalidate  action='' method='POST'>
                                        <div class="form-row">
                                            <div class="row mb-0">
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input class="form-control " name="numero" type="text" placeholder="." required/>
                                                        <label for="numero">Numéro</label>
                                                        <div class="invalid-feedback">Champs obligatoire</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input class="form-control" name="agence" type="text" placeholder="." required/>
                                                        <label for="agence">Agence </label>
                                                        <div class="invalid-feedback">Champs obligatoire</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-floating">
                                                        <select class="form-select shadow-success" name="nature" placeholder="." required>
                                                            <option value=''>....</option>
                                                            <option value='nationale'>Nationale</option>
                                                            <option value='internationale'>Internationale</option>
                                                        </select>
                                                        <label for="nature" >Nature </label>
                                                        <div class="invalid-feedback">Vous devez choisir une réponse</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2" >
                                                    <button class="btn btn-info" style="width:110px; float:right; height:40px; margin: 10px  0px;" type='submit'name='add'><i class="fa fa-plus-circle"></i> <b style="height:100px; float:center;  margin: 0px  0px;"> Ajouter</b></button>
                                                </div>
                                                <?php
                                                    if (isset($_POST['add'])) {
                                                        extract($_POST);
                                                        global $data;
                                                        
                                                        if (!empty($numero) && !empty($agence) && !empty($nature)){
                                                            //elimination des espace
                                                            global $data;
                                                            $req= $data->prepare('INSERT INTO banque(numero,agence,nature) VALUES(:numero,:agence,:nature)');
                                                            $req->execute([
                                                                'numero'=>$numero,
                                                                'agence'=>$agence,
                                                                'nature'=>$nature
                                                            ]);      
                                                        }
                                                    } 
                                                ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        
                        <table class="table table-bordered border-black">
                            <thead>
                                <tr>
                                    <th scope="col" class='bg-success text-white col-5' style='text-align:center'>Numéro</th>
                                    <th scope="col" class='bg-success text-white col-5' style='text-align:center'>Banque</th>
                                    <th scope="col" class='bg-success text-white col-3' style='text-align:center'>Nature</th>
                                    <th scope="col" class='bg-success text-white ' style='text-align:center'>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($content=$rq2->fetch()){ ?>
                                <tr>
                                    <td> <?php echo $content['numero']; ?> </td>
                                    <td> <?php echo $content['agence']; ?> </td>
                                    <td> <?php echo $content['nature']; ?> </td>
                                    <td>
                                    <button style="width:25px; height:25px;" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#supprimer" onclick='<?php $_SESSION['bank']= $content['ID'];?>'><i class="fa fa-trash" style="width:16px; float:right; height:16px; margin: -2px  -8px;" ></i></button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                </main>

                <div class="modal fade" id="supprimer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title text-white" id="staticBackdropLabel"><i class="fa fa-exclamation-triangle"></i> Attention</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form class="needs-validation" novalidate action='' method='post'>
                                <div class="modal-body">
                                    <b>Voulez-vous vraiment supprimer le compte <?php echo $content['agence']; ?>? </b>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-block" data-bs-dismiss="modal"><i class="fa fa-times"></i> NON</button>
                                    <button type="submit" name='delete' class="btn btn-success btn-block"><i class="fa fa-check"></i>  OUI</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

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

        <script>
            let change1 = document.getElementById("change1");
            let change2 = document.getElementById("change2");
            let change3 = document.getElementById("change3");
            let change4 = document.getElementById("change4");
            let change5 = document.getElementById("change5");
            let rep1 = document.getElementById("rep1");
            let rep2 = document.getElementById("rep2");
            let rep3 = document.getElementById("rep3");
            let rep4 = document.getElementById("rep4");
            let rep5 = document.getElementById("rep5");     
            rep1.style.display = "none";
            rep2.style.display = "none";
            rep3.style.display = "none";
            rep4.style.display = "none";
            toggRep.style.display='none';
            rep5.style.display = "none";
            change1.addEventListener("click", () => {
            if(getComputedStyle(rep1).display != "none"){
                rep1.style.display = "none";
                
            } else {
                rep1.style.display = "block";
            }
            })

            function rp2(){
            if(getComputedStyle(rep2).display != "none"){
                rep2.style.display = "none";
                
            } else {
                rep2.style.display = "block";
            }};
            change2.onclick = rp2;

            function rp3(){
            if(getComputedStyle(rep3).display != "none"){
                rep3.style.display = "none";
                
            } else {
                rep3.style.display = "block";
            }};
            change3.onclick = rp3;

            function rp4(){
            if(getComputedStyle(rep4).display != "none"){
                rep4.style.display = "none";
            } else {
                rep4.style.display = "block";
            }};
            change4.onclick = rp4;

            function toggg(){
            if(getComputedStyle(toggRep).display != "none"){
                toggRep.style.display = "none";
                
            } else {
                toggRep.style.display = "block";
            }};
            togg.onclick = toggg;

            function rp5(){
            if(getComputedStyle(rep5).display != "none"){
                rep5.style.display = "none";
                
            } else {
                rep5.style.display = "block";
            }};
            change5.onclick = rp5;

        </script>

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

        <script>
            document.getElementById("eye").addEventListener("click", function(e){
            var pwd = document.getElementById("pass1");
            if(pwd.getAttribute("type")=="password"){
                pwd.setAttribute("type","text");
            } else {
                pwd.setAttribute("type","password");
            }});

            document.getElementById("eye").addEventListener("click", function(e){
            var pwd = document.getElementById("pass2");
            if(pwd.getAttribute("type")=="password"){
                pwd.setAttribute("type","text");
            } else {
                pwd.setAttribute("type","password");
            }});

        </script>
    </body>
</html>


<?php
    if (isset($_POST['delete'])){
        $rq3 = $data->prepare("DELETE FROM banque WHERE ID=:ID");
        $rq3->execute(['ID' => $content['ID'] ]);
    }
?>