
<?php //  si l'utulisateur est non connecté alors bloquer la page de notifications 
    if (session_status()==PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['ID'])) header('Location: /e-facture/login.php');
    
    include 'Database.php';
    global $data;
    if (isset($_GET['id']) && $_GET['id']>0){ 
        $id= intval($_GET['id']); // securité : empecher l'utulisateur a éditer du texte en url
        $rq = $data->prepare("SELECT * FROM facture WHERE ID = :ID");
        $rq->execute(['ID' => $id]);
        $test=$rq->rowCount();
        if ($test==0) header('Location: /e-facture/404.php');

        $result=$rq->fetch();

        if(!empty($result['document'])) { $_SESSION['ERROR']="Vous ne pouvez plus visualiser ce document car vous avez déjà importer la facture cachetée";  header('Location: /e-facture/404.php');}
        if($result['reference']=='upload') { $_SESSION['ERROR']="Vous tentez d'accéder à une facture qui n'existe pas";  header('Location: /e-facture/404.php');}

        $rq1 = $data->prepare("SELECT * FROM designation WHERE ID_facture = :ID");
        $rq1->execute(['ID' => $id]);
        $length=$rq1->rowCount();
        if ($length==1)$result1=$rq1->fetch();

        $rq2=$data->prepare("SELECT * FROM banque WHERE ID = :ID");
        $rq2->execute(['ID' => $result['ID_banque']]);
        $bank=$rq2->fetch();

        $libellesFacture = $data->prepare("SELECT * FROM libellesFacture WHERE ID_facture = :ID");
        $libellesFacture->execute(['ID' => $id]);
        $countLibelle=$libellesFacture->rowCount();

    }else header('Location: /e-facture/404.php');

require('fpdf/fpdf.php');
class PDF extends FPDF
{
// Chargement des données
function LoadData($file)
{
    // Lecture des lignes du fichier
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

function Header()
{
    // Logo
    $this->Image('entete.png',0,6,210);
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    // Décalage à droite
    $this->Cell(80);
    // Titre
    //$this->Cell(30,10,'Titre',1,0,'C');
    // Saut de ligne
    $this->Ln(20);
}

function Coordonnees($numero,$client,$objet,$ref,$ice){

    $adjust=0;
    $this->Ln(26);
    $this->SetFont('Arial','B',16);
    $this->Cell(0,0,'FACTURE N '.$numero,0,0,'C');
    $this->Ln(14);
    $this->SetFont('Arial','BU',11);
    $this->Cell(0,0,'CLIENT :');
    $this->SetFont('Arial','B',11);
    $this->Ln(0);
    $this->Cell(18);
    $this->Cell(0,0,utf8_decode($client));
    $this->Ln(6);
    $this->SetFont('Arial','BU',11);
    $this->Cell(0,0,'OBJET :');
    $this->SetFont('Arial','B',11);
    $this->Ln(0);
    $this->Cell(18);
    $this->Cell(0,0,utf8_decode($objet));
    
    if ($ref!=NULL){
        $this->Ln(6);
        $this->SetFont('Arial','BU',11);
        $this->Cell(0,0,'REF :');
        $this->SetFont('Arial','B',11);
        $this->Ln(0);
        $this->Cell(12);
        $adjust+=6;
        $this->Cell(0,0,utf8_decode($ref));
    }else if ($ice == NULL) {
        $this->Ln(6);
        $adjust+=6;
    }

    if ($ice!=NULL){
        $this->Ln(6);
        $this->SetFont('Arial','BU',11);
        $this->Cell(0,0,'ICE :');
        $this->SetFont('Arial','B',11);
        $this->Ln(0);
        $this->Cell(11);
        $this->Cell(0,0,utf8_decode($ice));
        $adjust+=6;

    }else if ($ref == NULL) {
        $this->Ln(6);
        $adjust+=6;
    }

    $this->Ln(-46-$adjust);
}

function designation($designation,$quantite,$prix,$prix_total,$nature,$length,$jours){

    $this->Ln(60);
    $this->SetFont('Arial','B',11);
    global $countLibelle;
    if ($nature=='test performances' && $length==1 && $countLibelle==0 ){ // facture test performances

        $this->Ln(-10);
        $this->Cell(2);
        $criteres = explode("\n",$designation,2);
        $this->MultiCell(110,5,utf8_decode($criteres[0]));
        if (strlen($designation) >= 50) $this->Ln(-5);
        $this->SetFont('Arial','',11);
        $this->Ln(2);
        $this->Cell(5);
        if (!empty($criteres[1])){
            $this->MultiCell(110,5,utf8_decode($criteres[1]));
        }
        $this->Ln(-4.9); //alignement entre les lignes
        $this->Cell(145);
        $this->SetFont('Arial','B',11);
        $this->MultiCell(0,0,number_format($prix, 2, ',', ' '),0,0,false);

    }else if ($nature=='test performances' && $length==1 && $countLibelle!=0){

        $this->Ln(0);
        $this->Cell(3);
        $criteres = explode("\n",$designation,2);
        $this->MultiCell(110,5,utf8_decode($criteres[0]));
        if (strlen($designation) >= 50) $this->Ln(-5);
        $this->SetFont('Arial','',11);
        $this->Ln(2);
        $this->Cell(6);
        if (!empty($criteres[1])){
            $this->MultiCell(110,5,utf8_decode($criteres[1]));
        }
        $this->Ln(-4.9); //alignement entre les lignes
        $this->Cell(138);
        $this->SetFont('Arial','B',11);
        $this->MultiCell(0,0,number_format($prix, 2, ',', ' '),0,0,false);



    }elseif ($nature=='formation' && $length==1 && $jours==0){
        $this->Cell(2);
        $this->MultiCell(98,5,utf8_decode($designation));
        if (strlen($designation) >= 44) $this->Ln(-2);
        $this->Cell(102);
        if ($quantite>1) $this->MultiCell(0,0,$quantite.' personnes',0,0,false);
        else $this->MultiCell(0,0,$quantite.' personne',0,0,false);
        $this->Ln(0.5);
        $this->Cell(136);
        $this->MultiCell(0,0,number_format($prix, 2, ',', ' '),0,0,false);
        $this->Cell(163);
        $this->MultiCell(0,0,number_format($prix_total, 2, ',', ' '),0,0,false);

    }else if ($nature=='formation' && $length==1 && $jours!=0){ // formation avec jours

        $this->Ln(2);
        $this->Cell(2);
        $this->MultiCell(85,5,utf8_decode($designation));
        if (strlen($designation) >= 44) $this->Ln(-2);
        $this->Ln(-2);
        $this->Cell(90);
        $this->SetFont('Arial','B',10);
        if ($quantite>1) $this->MultiCell(0,0,$quantite.' personnes',0,0,false);
        else $this->MultiCell(0,0,$quantite.' personne',0,0,false);

        $this->SetFont('Arial','B',11);  
        $this->Ln(0);

        $this->Cell(125);
        $jours=str_replace('T', '', $jours); 
        $this->MultiCell(0,0,$jours,0,0,false);

        $this->Cell(141);
        $this->MultiCell(0,0,number_format($prix, 2, ',', ' '),0,0,false);
        $this->Cell(164);
        $this->MultiCell(0,0,number_format($prix_total, 2, ',', ' '),0,0,false);

    }
}

function designationMultiple($designation,$quantite,$prix,$prix_total,$nature,$length,$p){

    if ($p==1) $this->Ln(14); 
    else $this->Ln(4); 
    if ($prix==0 && $quantite==0 ){ //mise en page du titre de la designation
        $this->SetFont('Arial','B',11);
        $this->Cell(1);
        $this->MultiCell(100,5,utf8_decode($designation));

    }else{//les frais liées à la designation
        $this->SetFont('Arial','',11);
        $this->Cell(1);
        $this->MultiCell(100,5,utf8_decode($designation));
        $this->Ln(-2.5);
        $this->Cell(109);
        $this->MultiCell(0,0,number_format($prix, 2, ',', ' '),0,0,false);
        $this->Cell(143);
        $this->MultiCell(0,0,$quantite,0,0,false);
        $this->Cell(163);
        $this->Cell(20,0,number_format($prix*$quantite, 2, ',', ' '));
    }
}


function TVA($nature,$devise,$obs,$prix_total,$coodBanque,$dim1,$dim2,$bank_code,$location_code_bank, $bank_address, $location_address_bank,$cell_prix_total){

    $adjust=0; $devise_lettre=''; 
    global $countLibelle;

    $this->Ln($dim1+20);
    $this->SetFont('Arial','B',10);
    //require("Numbers/Words.php");
    require ("numbers_words.php");
    if ($devise==null) $devise='Dirhams';
    //$nw = new Numbers_Words();
    $obj = new nuts($prix_total, 'DIVERS');
    $nb = $obj->getFormated(" ", ",");

    if ($countLibelle ==3 ) {
        $this->MultiCell(180,5,utf8_decode(' Arrêté la présente facture à la somme de '). $obj->convert("fr-FR").' '.$devise.utf8_decode(' Toutes Taxes Comprises ')); 
        $this->Ln(5);
    }else $this->MultiCell(180,5,utf8_decode('Arrêté la présente facture à la somme de '). $obj->convert("fr-FR").' '.$devise.utf8_decode(' Toutes Taxes Comprises (dont TVA 20% : '. number_format($prix_total*0.2, 2, ',', ' ').' '.$devise.'). '));
    if($obs!=NULL){
        $this->Ln(11);
        $this->SetFont('Arial','BU',10);
        $this->Cell(0,0,'NB :');

        $this->SetFont('Arial','B',10);
        $this->Ln(0);
        $this->Cell(9);
        $this->Cell(0,0,utf8_decode($obs));
        
        $this->Image('banque.png',9.2,$coodBanque-12,190);

        $this->Ln($location_code_bank);
        $this->Cell(7);
        $this->Cell(0,0,utf8_decode($bank_code));

        $this->Ln($location_address_bank);
        $this->Cell(0,0,utf8_decode($bank_address));

        $adjust=11+$location_code_bank+$location_address_bank; //ajuster l'emplacement de cellule numero banque
    }else {
        $this->Ln(2);
        $this->Image('banque.png',9.2,$coodBanque-14,190);

        $this->Ln($location_code_bank+7);
        $this->Cell(7);
        $this->Cell(0,0,utf8_decode($bank_code));

        $this->Ln($location_address_bank);
        $this->Cell(0,0,utf8_decode($bank_address));

        $adjust= $location_code_bank+$location_address_bank + 9;
    }
    $this->Ln(-$dim1-6-$adjust);

    global $countLibelle; //appel de la valeur de count des libelles
    $this->Ln($dim2);
    $this->SetFont('Arial','B',12);
    $this->Cell($cell_prix_total);
    if($countLibelle==0) $this->MultiCell(0,0,number_format($prix_total, 2, ',', ' '),0,0,false);
    $this->Ln(-$dim2); 
}

function tableImg($table,$devise,$nature,$length,$jours){

    global $countLibelle;

    if ($devise==NULL){
        $this->Image($table,10,91,188);

    }elseif ($nature=='formation' && $length>1){ // formation avec sessions
        $this->Image('formation2_inter.png',10,91,188);
        $this->SetFont('Arial','B',13);
        $this->Ln(78);
        $this->Cell(110);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(-4);
        $this->Cell(166);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(80.5);
        $this->Cell(61);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(-154.5);

    }elseif ($nature=='formation' && $length==1 && $jours==0){ // formation sans session sans jours
        $this->Image('formation1_inter.png',10,91,188);
        $this->SetFont('Arial','B',10);
        $this->Ln(70);
        $this->Cell(133);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(0);
        $this->Cell(163);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(60.2);
        $this->Cell(51);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(-130.2);

    }elseif ($nature=='formation' && $length==1 && $jours!=0){ // formation sans session avec jours
        $this->Image('formation_jours_inter.png',10,91,188);
        $this->SetFont('Arial','B',11);
        $this->Ln(73);
        $this->Cell(144);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(0);
        $this->Cell(169);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(62);
        $this->Cell(54);
        $this->SetFont('Arial','B',12);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(-135);

    }elseif ($nature=='test performances' && $length==1 && $countLibelle==0){ // formation test performances

        $this->Image('tableau_inter.png',10,91,188);
        $this->SetFont('Arial','B',10);
        $this->Ln(65.3);
        $this->Cell(158);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(53.3);
        $this->Cell(66);
        $this->SetFont('Arial','B',11);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(-118.6);

    }elseif ($nature=='test performances' && $length==1 && $countLibelle==2){ // formation test performances : 2 champs

        $this->Image('inter_2champs.png',10,91,188);
        $this->SetFont('Arial','B',11);
        $this->Ln(67.7);
        $this->Cell(146);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(-67.7);

    }elseif ($nature=='test performances' && $length==1 && $countLibelle==3){ // formation test performances : 2 champs

        $this->Image('inter_3champs.png',10,91,188);
        $this->SetFont('Arial','B',11);
        $this->Ln(67.7);
        $this->Cell(146);
        $this->Cell(0,0,utf8_decode('('.$devise.')'));
        $this->Ln(-67.7);
    }
}

function position_champs(){

    $prix_finale=0;
    $this->SetFont('Arial','B',12);
    $this->Ln(134);
    global $data;
    $libellesFacture = $data->prepare("SELECT * FROM libellesFacture WHERE ID_facture = :ID");
    $id= intval($_GET['id']);
    $libellesFacture->execute(['ID' => $id]);

    while($libelle=$libellesFacture->fetch()){
        $this->Cell(5);
        $this->Cell(0,0,utf8_decode($libelle['libelle']));
        $this->Ln(0);
        $this->Cell(136);
        $this->Cell(0,0,number_format($libelle['prix'], 2, ',', ' '));
        $this->Ln(7.5);
        $prix_finale=$libelle['prix'];
    }
    $this->Ln(-156.5);
    return $prix_finale;
}
// Pied de page
function Footer()
{
    $this->Image('footer.png',10,270,190);
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
    // Numéro de page
    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
} 



if ($length==1 && $result['nature']=='test performances' && $countLibelle==0 ){ //facture test performances : version simple
    
    $pdf = new PDF();
    $pdf->SetFont('Arial','B',12);
    $pdf->AddPage();
    $pdf->Coordonnees($result['numero'],$result['client'],$result['objet'],$result['reference'],$result['ICE']);
    $pdf->tableImg('tableau.png',$result['devise'],$result['nature'],$length,$result1['jours']);
    $pdf->TVA($result['nature'],$result['devise'],$result['observations'],$result['prix_total'],192,105,95,$bank['numero'],13.1, $bank['agence'],5,143);
    $pdf->designation($result1['designation'],'',$result1['prix'],$result['prix_total'],$result['nature'],$length,'');
    //$pdf->FancyTable($header,$data);
    $pdf->Output();
    //$fpdf->Output('filename.pdf','F'); 

}else if ($length==1 && $result['nature']=='test performances' && $countLibelle==2 ){ //facture test performances : version 2 champs

    $pdf = new PDF();
    $pdf->SetFont('Arial','B',12);
    $pdf->AddPage();
    $pdf->Coordonnees($result['numero'],$result['client'],$result['objet'],$result['reference'],$result['ICE']);
    $pdf->tableImg('2champs.png',$result['devise'],$result['nature'],$length,$result1['jours']);
    $prix_final=$pdf->position_champs();
    $pdf->TVA($result['nature'],$result['devise'],$result['observations'],$prix_final,215,134,110,$bank['numero'],14.8, $bank['agence'],5,143);
    $pdf->designation($result1['designation'],'',$result1['prix'],$result['prix_total'],$result['nature'],$length,'');
    $pdf->Output();

}else if ($length==1 && $result['nature']=='test performances' && $countLibelle==3 ){ //facture test performances : version 3 champs

    $pdf = new PDF();
    $pdf->SetFont('Arial','B',12);
    $pdf->AddPage();
    $pdf->Coordonnees($result['numero'],$result['client'],$result['objet'],$result['reference'],$result['ICE']);
    $pdf->tableImg('3champs.png',$result['devise'],$result['nature'],$length,'');
    $prix_final=$pdf->position_champs();
    $pdf->TVA($result['nature'],$result['devise'],$result['observations'],$prix_final,220,133,110,$bank['numero'],13.1, $bank['agence'],5,143);
    $pdf->designation($result1['designation'],'',$result1['prix'],$result['prix_total'],$result['nature'],$length,'');
    $pdf->Output();

}else if($length==1 && $result['nature']=='formation' && $result1['jours'][-1]=='T'){ //facture formation : une seule session avec jours

    $pdf = new PDF();
    $pdf->SetFont('Arial','B',12);
    $pdf->AddPage();
    $pdf->Coordonnees($result['numero'],$result['client'],$result['objet'],$result['reference'],$result['ICE']);
    $pdf->tableImg('formation_jours.png',$result['devise'],$result['nature'],$length,$result1['jours']);
    $pdf->TVA($result['nature'],$result['devise'],$result['observations'],$result['prix_total'],206,120,111,$bank['numero'],12.1, $bank['agence'],4.1,130);  
    $pdf->designation($result1['designation'],$result1['quantite'],$result1['prix'],$result['prix_total'],$result['nature'],$length,$result1['jours']);
    $pdf->Output();

}else if ($length==1 && $result['nature']=='formation'){//facture formation : une seule session sans jours

    $pdf = new PDF();
    $pdf->SetFont('Arial','B',12);
    $pdf->AddPage();
    $pdf->Coordonnees($result['numero'],$result['client'],$result['objet'],$result['reference'],$result['ICE']);
    $pdf->tableImg('formation1.png',$result['devise'],$result['nature'],$length,'');
    $pdf->TVA($result['nature'],$result['devise'],$result['observations'],$result['prix_total'],203,115,106.5,$bank['numero'],14.1, $bank['agence'],4.6,135);  
    $pdf->designation($result1['designation'],$result1['quantite'],$result1['prix'],$result['prix_total'],$result['nature'],$length,$result1['jours']);
    $pdf->Output();

}

else if ($length>1 && $result['nature']=='formation'){//facture formation : plusieurs sessions

    $pdf = new PDF();
    $pdf->SetFont('Arial','B',12);
    $pdf->AddPage();
    $pdf->Coordonnees($result['numero'],$result['client'],$result['objet'],$result['reference'],$result['ICE']);
    $pdf->tableImg('formation2.png',$result['devise'],$result['nature'],$length,'');
    $pdf->TVA($result['nature'],$result['devise'],$result['observations'],$result['prix_total'],223,138,131,$bank['numero'],11.1, $bank['agence'],4.6,135);  
    $count=1; 
    $pdf->Ln(49);
    while($ligne=$rq1->fetch()){
        $pdf->designationMultiple($ligne['designation'],$ligne['quantite'],$ligne['prix'],$result['prix_total'],$result['nature'],$length,$count);
        $count++;
    }
    
    $pdf->Output();
}

//TVA($nature,$devise,$obs,$prix_total,$coodBanque,$dim1,$dim2,$bank_code,$location_code_bank, $bank_address, $location_address_bank,$cell_prix_total)
// $dim1 : l'emplacement de tva horizontalement dans la fiche 
// $dim2 : l'emplacement de prix_total horizontalement dans la fiche 
//coodBanque : reglage de la hauteur du cadre de reference de la banque
//level: hauteur de la cellule
?>