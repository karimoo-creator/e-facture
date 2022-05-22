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
            <img src="facture.png" class="navbar-brand ps-3" alt="img-thumbnail" style="width: 200px; text-align: center; margin: 0px  -16px;" >
            
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Karim MOUHSSINY <i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="reglages.php">Réglages</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="login.html">Deconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <br>
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
                            
                            
                            <div class="sb-sidenav-menu-heading">Divers</div>
                            <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Statistiques AMEE
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-sms"></i></div>
                                Chat Box
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
                        <h1 class="mt-4"><i class="fa fa-edit"></i> Modification de la facture <b class='text-success'> 10/PAG/18</b></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item "><a class='text-success' href="dashboard.php">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Gestion des factures</li>
                        </ol>
                        
                        <!--<div style="height: 100vh"></div>
                        <div class="card mb-4"><div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div></div> 
                    
                    
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Facture formation</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">éditer</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Facture test de performances</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">éditer</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-info text-white mb-4">
                                    <div class="card-body">Rapport financier</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">éditer</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Facture internationale</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">éditer</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="card mb-4">
                            <div class="card-body">
                                
                                <form class="needs-validation" novalidate action='dashboard.php'>
                                    <div class="form-row">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control " id="numFact" type="text" value="10/PAG/18" placeholder="num facture" required>
                                                    <label for="numFact">Numéro de la facture </label>
                                                    <div class="valid-feedback">Ok </div>
                                                    <div class="invalid-feedback">Valeur incorrecte</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" type="text" value="Holding AL OMRANE"  placeholder="nom client" required/>
                                                    <label for="inputLastName">Client </label>
                                                    <div class="valid-feedback">Ok </div>
                                                    <div class="invalid-feedback">Valeur incorrecte</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="objet" type="text" value="Frais de formation sur l'éfficacité énergetique" placeholder="rien" required/>
                                            <label for="objet">Objet de la facture</label>
                                            <div class="valid-feedback">Ok </div>
                                            <div class="invalid-feedback">Valeur incorrecte</div>
                                        </div>
                                        
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="reference" type="text" placeholder="rien">
                                            <label for="reference">Référence de la facture</label>
                                            
                                        </div>

                                        <div class="form-floating mb-3">
                                                
                                            <textarea class="form-control" id="designation" rows="8"  placeholder="designation " required>
                                                Session de formation sur l'efficacité energetique dans le batiment
                                                Marrakech les 28 et 29 novembre 2017.
                                                Documentation et supports logistiques
                                            </textarea>
                                            <label for="designation">Designation</label>
                                            <div class="valid-feedback">Ok </div>
                                            <div class="invalid-feedback">Valeur incorrecte</div>
                                            </div>
                                            <table class="table table-bordered ">
                                                <thead>
                                                    <tr>
                                                    <th scope="col" class=' col-5 bg-secondary text-white-50'>Opérations</th>
                                                    <th scope="col" class='col-1 bg-secondary text-white-50'>PU/Session</th>
                                                    <th scope="col" class=' col-1 bg-secondary text-white-50'>Nbr session</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class='bg-light'>
                                                    <td>
                                                        <textarea class="form-control" id="ope1" rows="1" placeholder="opération 1 "  required>frais de préparation et d'animation</textarea>
                                                        <div class="valid-feedback">Ok </div>
                                                        <div class="invalid-feedback">Vous devez éditer au moins une opération pour valider la facture</div>
                                                    </td>
                                                    <td>        
                                                        <input class="form-control " id="prix1" type="number"  max='100000' value='20000' required>
                                                        <div class="valid-feedback">Ok </div>
                                                        <div class="invalid-feedback">Valeur incorrecte</div>       
                                                    </td>
                                                        
                                                    <td>
                                                        <input class="form-control " id="session1" type="number"  value='7' required>
                                                        <div class="valid-feedback">Ok </div>
                                                        <div class="invalid-feedback">Valeur incorrecte</div> 
                                                    </td>
                                                    </tr>

                                                    <tr class='bg-light'>
                                                    <td>
                                                        <textarea class="form-control" id="designation" rows="1" placeholder="opération 2 ">Pauses cafés et déjeuners</textarea>
                                                    </td>
                                                    <td>        
                                                        <input class="form-control " id="prix2" type="number" value='17000' max='100000'>
                                                    </td>
                                                        
                                                    <td>
                                                        <input class="form-control " id="session2" type="number" value='7'>
                                                    </td>
                                                    </tr>
                                                    <tr class='bg-light'>
                                                    <td>
                                                        <textarea class="form-control" id="designation" rows="1" placeholder="opération 3 " ></textarea>
                                                    </td>
                                                    <td>        
                                                        <input class="form-control " id="quantite" type="number"  max='99'>
                                                    </td>
                                                        
                                                    <td>
                                                        <input class="form-control " id="quantite" type="number">
                                                    </td>
                                                    </tr>

                                                    <tr class='bg-light'>
                                                    <td>
                                                        <textarea class="form-control" id="designation" rows="1" placeholder="opération 4 "></textarea>
                                                    </td>
                                                    <td>        
                                                        <input class="form-control " id="quantite" type="number"  max='99'>
                                                    </td>
                                                        
                                                    <td>
                                                        <input class="form-control " id="quantite" type="number">
                                                    </td>
                                                    </tr>

                                                    <tr class='bg-light'>
                                                    <td>
                                                        <textarea class="form-control" id="designation" rows="1" placeholder="opération 5 "></textarea>
                                                    </td>
                                                    <td>        
                                                        <input class="form-control " id="quantite" type="number"  max='99'>
                                                    </td>
                                                        
                                                    <td>
                                                        <input class="form-control " id="quantite" type="number">
                                                    </td>
                                                    </tr>
                                                    
                                                    
                                                </tbody>
                                            </table>
                                            <div class="form-floating mb-3">
                                            <textarea class="form-control" id="obs" rows="8" placeholder="observations " ></textarea>
                                            <label for="obs">Observations</label>
                                                
                                            </div>
                                        </div>       
                                    </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" type='submit'><i class="fa fa-save"></i> enregistrer</button>
                                </form>
                        <button type="button" class="btn btn-danger"><i class="fa fa-trash-alt"></i> supprimer</button>
                        <button type="button" class="btn btn-info" onclick="window.location.href='/e-facture/print.php'"><i class="fa fa-print"></i> imprimer</button>
                    </div>
                </main>
                <br>
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