<?php
    require('../fpdf/fpdf.php');

    /*
     * On récupère les participants d'un événement défini
     */
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
    $requete = $bdd->prepare("SELECT nom,prenom FROM utilisateurs INNER JOIN participation on utilisateurs.ID_Utilisateurs = participation.Utilisateur WHERE participation.Evenement = :num");
    $requete->bindValue(':num', $_GET['listParticipant'], PDO::PARAM_INT);
    $requete->execute();
    $ros = $requete -> fetchAll();

    $check = $requete->rowCount();

    class PDF extends FPDF {
        /*
         * On définit l'en-tête avec les paramètres suivants : police, taille des cellules, nom des colonnes,
         */
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

        /*
         * On définit le pied de page avec les paramètres suivants : une ligne pour fermer le tableau, un espacement de 1.5cm, la police,
         * le nombre de page
         */
        function Footer(){
            $this->Cell(190,0,'','T',1,'',true);
            $this->SetY(-15);
            $this->SetFont('Arial','',8);
            $this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
        }

    }

    /*
     * On affiche le PDF généré, dans une page annexe sur le navigateur
     * On définit des paramètres
     */
    $pdf = new PDF();
    $pdf->AliasNbPages('{pages}');
    $pdf->SetAutoPageBreak(true,15);
    $pdf->AddPage();
    $pdf->SetFont('Arial','',9);
    $pdf->SetDrawColor(180,180,255);

    /*
     * On insère des valeurs dans les colonnes
     */
    for($i = 0; $i <$check; $i++){
        $pdf->Cell(95,5,$ros[$i]['nom'],'LR',0, 'C');
        $pdf->Cell(95,5,$ros[$i]['prenom'],'LR',1, 'C');
    }

    $pdf->Output();
?>