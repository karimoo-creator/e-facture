<?php
if (session_status()==PHP_SESSION_NONE) session_start();
if (empty($_SESSION['ID'])){ header('Location: /e-facture/login.php'); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Visualiser une facture</title>
        <link rel="icon" type="image/png" href="icon.png" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body>
</body>
</html>

<?php

include 'Database.php';
global $data;
$id= intval($_GET['id']);

$content = $data->prepare("SELECT * FROM facture WHERE ID =:ID");
$content->execute([ 'ID' => $id]);
$result=$content->fetch();

header("Content-type: application/pdf;");
if (!empty($result['document'])) echo $result['document'];
else echo "Cette facture n'existe pas";
?>
