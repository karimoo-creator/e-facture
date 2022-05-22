<?php //  si l'utulisateur est non connecté alors bloquer la page de notifications 
    if (session_status()==PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['ID'])) header('Location: /e-facture/login.php');

    include 'cleanFacture.php';
    include 'Database.php';
    global $data;
    $rq = $data->prepare("SELECT * FROM utilisateurs WHERE ID = :ID");
    $rq->execute(['ID' => $_SESSION['ID']]);
    $result=$rq->fetch();

    $rq2 = $data->prepare('SELECT * FROM facture');
    $rq2->execute();
    $length=$rq2->rowCount();

    $mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
    $_SESSION['error']=0;
    $_SESSION['acces']=1;
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

                            <a class="nav-link" href="safeFactures.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                Stocker des factures
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
                        <h1 class="mt-4">Tableau de bord </h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Mois : <?php echo $mois[date("n")];?> | <?php echo $length;?> factures enregistrées</li>
                        </ol>
            
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-success">
                                        <i class="fas fa-chart-area me-1 text-white-50"></i>
                                        <b class='text-white-50'>Évolution trimestrielle des factures : Trimestre 3</b>
                                        
                                    </div>
                                    
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                    
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4 ">
                                    <div class="card-header  bg-success ">
                                        <i class="fas fa-chart-bar me-1 text-white-50"></i>
                                        <b class='text-white-50'>Statistiques annuelles de l'année <?php echo date('Y');?></b>
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header bg-success">
                                <i class="fas fa-table me-1 text-white-50"></i>
                                <b class='text-white-50'>Factures</b>
                                 
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th width="60px">Numéro</th>
                                            <th>Client</th>
                                            <th>Objet</th>
                                            <th width="120px">Date</th>
                                            <th width="50px">Options</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Numéro</th>
                                            <th>Client</th>
                                            <th>Objet</th>
                                            <th>Date</th>
                                            <th>Options</th>
                                            
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php while ($ligne = $rq2 -> fetch()) { ?>
                                        <tr>
                                            <td><?php echo $ligne['numero'];?></td>
                                            <td><?php echo $ligne['client'];?></td>
                                            <td><?php echo $ligne['objet'];?></td>
                                            <td><?php echo date('d/m/Y', strtotime($ligne['date_creation']));?></td>
                                            <td>
                                                <button style="width:25px; height:25px;" type="button" class="btn btn-success" onclick="window.location.href='/e-facture/viewFacture.php?id='+<?php echo $ligne['ID'];?>"><i class="fa fa-eye" style="width:16px; float:right; height:16px; margin: -2px  -8px;" ></i></button>
                                                <?php if(empty($ligne['document'])) {?>
                                                <button style="width:25px; height:25px;" type="button" class="btn btn-info" onclick="window.location.href='/e-facture/print.php?id='+<?php echo $ligne['ID'];?>"><i class="fa fa-print" style="width:16px; float:right; height:16px; margin: -2px  -8.5px;" ></i></button>
                                                <?php }else{?>
                                                <button style="width:25px; height:25px;" type="button" class="btn btn-warning" onclick="window.location.href='/e-facture/facture.php?id='+<?php echo $ligne['ID'];?>"><i class="fa fa-cloud-upload-alt" style="width:16px; float:right; height:16px; margin: -2px  -8.5px;" ></i></button>
                                                <?php }?>

                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                
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


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script>
            Chart.defaults.global.defaultFontFamily = 'Nunito','-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
            Chart.defaults.global.defaultFontColor = '#292b2c';

            // Area Chart
            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["mois 1", "mois 2", "mois 3", "mois 4"],
                datasets: [{
                label: "Sessions",
                lineTension: 0.3,
                backgroundColor: "rgb(154,205,50,0.4)",
                borderColor: "rgba(0,128,0,1)",
                pointRadius: 5,
                pointBackgroundColor: "rrgba(0,128,0,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(0,128,0,1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: [33, 42, 56, 39],
                }],
            },
            options: {
                scales: {
                xAxes: [{
                    time: {
                    unit: 'date'
                    },
                    gridLines: {
                    display: false
                    },
                    ticks: {
                    maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 100,
                    maxTicksLimit: 5
                    },
                    gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                    }
                }],
                },
                legend: {
                display: false
                }
            }
            });
        </script>
    <?php 
    $statics=array(); $sum=0;

        for($j=1;$j<13;$j++){
            $date1= date('Y').'-'.$j.'-01';      $date2=date('Y').'-'.$j.'-30';
            $rq1 = $data->prepare("SELECT prix_total FROM facture WHERE date_creation BETWEEN :date1 AND :date2");
            $rq1->execute(['date1' => $date1, 'date2' => $date2 ]);
            $size=$rq1->rowCount();
            if ($size==1) {
                $amount=$rq1->fetch();
                array_push($statics, $amount['prix_total']);
            }else{
                while($ligne=$rq1->fetch()){
                    $sum+=$ligne['prix_total'];
                }
                array_push($statics, $sum);
                $sum=0;
            }
        }
    ?>


        <script>
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';

        // Bar Chart Example
        var ctx = document.getElementById("myBarChart");

        var table = <?php echo json_encode($statics); ?>;

        var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin",'Juil', 'Aout','Septembre','Octobre','Novembre','Décembre'],
            datasets: [{
            label: "Revenue",
            backgroundColor: "rgb(154,225,150,0.8)",
            borderColor: "rgba(2,117,216,1)",
            data: [table[0], table[1], table[2], table[3], table[4], table[5], table[6],table[7],table[8],table[9],table[10],table[11]],
            }],
        },
        options: {
            scales: {
            xAxes: [{
                time: {
                unit: 'month'
                },
                gridLines: {
                display: false
                },
                ticks: {
                maxTicksLimit: 12
                }
            }],
            yAxes: [{
                ticks: {
                min: 0,
                max: 300000,
                maxTicksLimit: 6
                },
                gridLines: {
                display: true
                }
            }],
            },
            legend: {
            display: false
            }
        }
        });     
        </script>

        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>

