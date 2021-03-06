<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>Guide</title>
        <link rel="icon" type="image/png" href="icon.png" />
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">           
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"></button>
            <img src="facture.png" class="navbar-brand ps-3" alt="img-thumbnail" style="width: 200px; text-align: center; margin: 0px  -45px;">
            
            <ul class="navbar-nav ms-auto me-0 me-md-3  ">
            <?php if (empty($_SESSION['ID'])){?><button class='btn btn-outline-light' type='button' onclick="window.location.href='/e-facture/login.php'">se connecter</button>
                <?php }else{ ?> <button class='btn btn-outline-light' type='button' onclick="window.location.href='/e-facture/dashboard.php'">tableau de bord</button> <?php } ?>
            </ul>
        </nav>
            <div id="layoutSidenav_content">                                   

                <main>
                    <div class="container-fluid px-4">
                        <br><br>
                        <h1 class="mt-4"><i class="fas fa-book"></i> Guide de fonctionnement de la plateforme</h1><br>

                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" width="1000" height="500">
                            <div class="carousel-inner">
                              <div class="carousel-item active">
                                <img class="d-block w-100" src="fiche1.jpg" alt="First slide" width="1000" height="500">
                              </div>
                              <div class="carousel-item">
                                <img class="d-block w-100" src="fiche2.jpg" alt="Second slide" width="1000" height="500">
                              </div>
                              
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <br>
                        <div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <i class="fas fa-question-circle text-dark"></i> <b class='text-dark' >Comment je peux r??cuperer mon mot de passe ?</b>
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        Vous pouvez r??cuperer votre mot de passe en cliquant sur <b>mot de passe oubli??</b> puis vous devez saisir votre mail de connexion. un courrier sera envoy?? directement ?? votre bo??te mail ou vous allez trouvez un nouveau mot de passe.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        <i class="fas fa-question-circle text-dark"></i> <b class='text-dark' >Comment je peux ajouter un nouveau utilisateur dans la plateforme ?</b>
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
        Les administrateurs sont les seuls qui peuvent ajouter des utilisateurs ?? partir de la page <b>r??glages</b>. Le nouveau utilisateur ne peut pas avoir un num??ro de CNIE  qui existe d??j?? dans la base de donn??es et de m??me pour le mail. 
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        <i class="fas fa-question-circle text-dark"></i> <b class='text-dark' >Comment je peux modifier une facture d??j?? enregistr??e ?</b>
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
        Si vous n'avez pas encore importer la facture cachet??e, alors vous pouvez modifier la facture en cliquant sur <i class="fas fa-eye text-dark"></i> dans le tableau de bord puis <b>modifier</b>.
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
        <i class="fas fa-question-circle text-dark"></i> <b class='text-dark' >Comment je peux modifier mes coordonn??es dans la plateforme ?</b>
        </button>
      </h5>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
      <div class="card-body">
        Vous pouvez changer vos coordonn??es ?? travers la page <b>r??glages</b>. Vous pouvez aussi changer votre mot de passe.
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingFive">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
        <i class="fas fa-question-circle text-dark"></i> <b class='text-dark' >Est-ce-que je peux modifier une facture apr??s le t??lechargement du document scann?? ?</b>
        </button>
      </h5>
    </div>
    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
      <div class="card-body">
        La modification et l'impresson de la facture initiale nes sera plus disponible apr??s l'importation de la facture cachet??e. Dans ce cas vous pouvez la supprimer  et recommencer la cr??ation d'une nouvelle facture. 
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingSix">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
        <i class="fas fa-question-circle text-dark"></i> <b class='text-dark' >Quelles sont les causes pour rejeter la cr??ation d'une facture ?</b>
        </button>
      </h5>
    </div>
    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
      <div class="card-body">
        Une facture est rejet??e par le syst??me si elle contient : <br>
              - un num??ro de facture qui existe d??j?? dans le syst??me. <br>
              - des scripts malveillantes pour bloquer la plateforme. <br>
        Si vous n'avez pas finaliser les 3 ??tapes de cr??ation alors la facture sera rejet??e.     
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="headingSeven">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
        <i class="fas fa-question-circle text-dark"></i> <b class='text-dark' >Comment je peux modifier mon r??le dans la plateforme ?</b>
        </button>
      </h5>
    </div>
    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
      <div class="card-body">
        Les administrateurs sont les seuls qui peuvent modifier leurs r??les et les r??les des contributeurs ?? travers la page <b>r??glages > gestion des r??les </b>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingEight">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
        <i class="fas fa-question-circle text-dark"></i> <b class='text-dark' >Comment je peux ajouter une facture d??j?? ??dit??e hors la plateforme ?</b>
        </button>
      </h5>
    </div>
    <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
      <div class="card-body">
        Vous pouvez directment ajouter une nouvelle facture d??j?? ??dit??e sous forme (.pdf) dans la plateforme ?? travers la page <b>Stocker des factures </b>
      </div>
    </div>
  </div>

</div>  
                    </div>
                </main>
                <br>

                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Tout droit r??serv?? &copy; AMEE</div>
                            <div>
                                <a class="text-success" href="https://www.amee.ma/fr/home">Agence Marocaine pour l'Efficacit?? Energ??tique</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
      <script src="js/scripts.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
      <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
