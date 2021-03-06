<?php

    // On récupère l'image sélectionné
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');

    $requete = $bdd->prepare("SELECT * FROM image WHERE ID_Image=?");
    $requete->execute(array($_GET['numImage']));
    $ros = $requete->fetch();

    /*
     * S'il y a un paramètre envoyé en GET à la fonction : ID de l'image
     * On stocke le nom de l'image dans une variable
     * On stocke le chemin où sera enregistré l'image, dans une variable
     */
    if(!empty($_GET['numImage'])){
        $fileName = $ros['url'];
        $filePath= 'images\photosEvenement/'.$ros['Evenement'].'/'.$fileName;

        /*
         * Si l'image existe au chemin indiqué
         * On propose son téléchargement
         */
        if(!empty($fileName) AND file_exists($filePath)){
            header('Content-Description: File Transfer');
            header('Content-Type: image/png, application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            header('Content-Transfer-Encoding: binary');
            readfile($filePath);
        }
    }
?>