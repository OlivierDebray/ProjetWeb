<?php
    require('../fpdf/fpdf.php');

    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
    $requete = $bdd->prepare("SELECT nom,prenom FROM utilisateurs INNER JOIN participation on utilisateurs.ID_Utilisateurs = participation.Utilisateur WHERE participation.Evenement = :num");
    $requete->bindValue(':num', $_GET['listParticipant'], PDO::PARAM_INT);
    $requete->execute();
    $ros = $requete -> fetchAll();

    $check = $requete->rowCount();

    class PDF extends FPDF {
        function Header(){
            $this->SetFont('Arial','B',15);

            $this->Cell(12);

            $this->Image('../images/logo.png',10,10,10);

            $this->Cell(100,10,'Liste des participants',0,1);

            $this->Ln(5);

            $this->SetFont('Arial','B',11);

            $this->SetFillColor(180,180,255);
            $this->SetDrawColor(180,180,255);
            $this->Cell(95,5,'Nom',1,0,'C',true);
            $this->Cell(95,5,'Prenom',1,1,'C',true);

        }

        function Footer(){
            //add table's bottom line
            $this->Cell(190,0,'','T',1,'',true);

            //Go to 1.5 cm from bottom
            $this->SetY(-15);

            $this->SetFont('Arial','',8);

            //width = 0 means the cell is extended up to the right margin
            $this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
        }

    }
    $pdf = new PDF();
    $pdf->AliasNbPages('{pages}');
    $pdf->SetAutoPageBreak(true,15);
    $pdf->AddPage();
    $pdf->SetFont('Arial','',9);
    $pdf->SetDrawColor(180,180,255);

    for($i = 0; $i <$check; $i++){
        $pdf->Cell(95,5,$ros[$i]['nom'],'LR',0, 'C');
        $pdf->Cell(95,5,$ros[$i]['prenom'],'LR',1, 'C');
    }

    $pdf->Output();
?>