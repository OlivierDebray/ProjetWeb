<?php

//    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
//
//    $requete = $bdd->prepare("SELECT * FROM evenements WHERE ID_Evenements =:num");
//    $requete->bindValue(':num', $_GET['activityImage'], PDO::PARAM_INT);
//
//    $requete->execute();
//    $ros = $requete -> fetch();

    if(!empty($_GET['activityImage'])){
        //$fileName = $ros['Image'];
        $filePath= $_GET['url']; //'images/Suggestionbox/'.$fileName;
        //if(!empty($fileName) AND file_exists($filePath)){
        if(file_exists($filePath)){

        header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="test.png"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            header('Content-Transfer-Encoding: binary');
            readfile($filePath);

        } else{
//            $page = 'suggestionBox.php';
//            header('Location:'.$page);
        }
    }
?>