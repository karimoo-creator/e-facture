<?php
if (session_status()==PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['ID'])) header('Location: /e-facture/dashboard.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>e-facture</title>
        <link rel="icon" type="image/png" href="icon.png" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <style>
        body  {
          background-image: url("amee1.jpg");
          background-color: #cccccc;
        }
    </style>
    <body>
        
        <div id="layoutAuthentication" >
            <div id="layoutAuthentication_content" >
                <main>
                    <div class='container' >
                        <div class="row justify-content-center">
                            <div class="col-lg-5"> 
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header" style="text-align: center">
                                        <img src="facture.png" class="navbar-brand ps-3" alt="img-thumbnail" style="height: 70px;" ></div>
                                    <div class="card-body">
                                        <form class="needs-validation" novalidate action='' method='POST'>
                                            <div class="form-floating mb-3">
                                                <input class="form-control " name="email" type="email" placeholder="name@amee.ma" required/>
                                                <label for="email">Adresse électronique</label>
                                                <div class="invalid-feedback">Veuillez saisir l'adresse électronique</div>
                                            </div>
                                            <div class='row'>
                                                <div class="col-md-11">
                                                    <div class="form-floating mb-0">
                                                        <input type="password" placeholder="Password" id='pass' name="pass" class="form-control masked" required/>
                                                        <label name="pass">Mot de passe</label>
                                                        <div class="invalid-feedback">Veuillez saisir le mot de passe</div>
                                                    </div>
                                                </div>
                                                <button type="button" class='col-md-1 btn btn-light' style='width:16px; height:25px margin: 0px  0px;' id="eye"><i class="fa fa-eye" style="width:16px; float:right; margin: -2px  -8px;" ></i></button>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" id="rememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="rememberPassword">se rappeler du mot de passe</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small text-success" href="password.php ">mot de passe oublié ?</a>
                                                <button class="btn btn-success" type='submit' name='connect' >se connecter</button>
                                            </div>
                                        </form>
                                        <?php include 'connexion.php'; if (!empty($_SESSION['connect'])){?>
                                        <br>
                                        <div class="card mb-0 alert alert-danger" role="alert">
                                            <div class="row ">
                                                <div class='col-md-9 mb-0'><?php echo $_SESSION['connect'];?>. Veuillez réessayer.</div>
                                                <div class='col-md-2 mb-0'>
                                                    <button type="button" class="btn-close btn-danger" data-bs-dismiss="alert" aria-label="Close" style='height:16px; margin: 0px  80px;'></button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } $_SESSION['connect']=''; ?>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"> En cas de problème <a class="text-success" href="mailto:contact@amee.ma">contactez-nous </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-success mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <a class="text-white-50" href="guide.php">Guide E-facture</a>
                            <div class='text-white'>
                                <a class="text-white-50" href="https://www.amee.ma/fr/home">Agence marocaine pour l'éfficacité énergetique </a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
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
            var pwd = document.getElementById("pass");
            if(pwd.getAttribute("type")=="password"){
                pwd.setAttribute("type","text");
            } else {
                pwd.setAttribute("type","password");
            }
            });
        </script>
    </body>
</html>
