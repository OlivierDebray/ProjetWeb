<?php
session_start();

/*
 * On définit une variable, utilisée pour afficher une erreur
 * On stocke dans une variable la date actuelle
 * On se connecte à la BDD
 */
$valide = 1;
$date = getdate();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb', 'root', '');

// Si on clique sur le bouton pour ajouter une photo
if(isset($_POST['formajout']))
{
    // Création d'une fonction qui va modifier le tableau
    function reArrayFiles(&$attachFile) 
    {
        $file_ary = array();
        $file_count = count($attachFile['name']);
        $file_keys = array_keys($attachFile);
        for ($i=0; $i<$file_count; $i++) 
        {
            foreach ($file_keys as $key) 
            {
                $file_ary[$i][$key] = $attachFile[$key][$i];
            }
        }
        return $file_ary;
    }

    // On stocke les images insérées dans une variable
    $file_ary = reArrayFiles($_FILES['attachFile']);

    /*
     * Pour chaque image
     * On récupère des paramètres : type, nom, taille,
     */
    foreach($file_ary as $file)
    {
        $tmp_name = $file['tmp_name'];
        $type = $file['type'];
        $name = $file['name'];
        $size = $file['size'];

        /*
         * S'il y a une image insérée
         * On crée un dossier, ayant pour nom l'ID de l'événement, qui va stocker les images insérées
         * On vérifie l'ID des images
         * On incrémente l'ID des images +1
         * On récupère l'extension de l'image insérée
         * On convertit l'extension de l'image récupérée en minuscule
         * On définit dans une array les extensions acceptées
         * On stocke le nom de l'image constitué de la date et du temps, suivis de l'extension dans une variable
         * On stocke le chemin où sera sauvegardée l'image dans une variable
         */
        if (!empty($name)) 
        {
            $chemin = "images/photosEvenement/".$_GET['numEvent'];

            if (!is_dir($chemin)) 
            {
                mkdir($chemin);
            }

            $checkImageReq =$bdd->prepare("SELECT * FROM image ORDER BY ID_Image DESC LIMIT 1");
            $checkImageReq->execute(); 
            $checkImage=$checkImageReq->fetch();
            $checkImageReq->closeCursor();
            $checkImage = $checkImage['ID_Image'] + 1;
            $extension = explode('.', $name);
            $image_extension = strtolower(end($extension));
            $allowed = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'bmp');
            $new_img_name = $date['mday'].$date['mon'].$date['year'].'_'.$date['hours'].$date['minutes'].$date['seconds'].$name;
            $target = $chemin."/".$new_img_name;

            /*
             * Si l'extension de l'image insérée correspond aux extensions autorisées
             * On déplace l'image insérée au chemin indiqué
            */
            if(in_array($image_extension, $allowed))
            {
                move_uploaded_file($tmp_name,$target);
            }

            // On confirme à l'utilisateur que l'image a bien été ajoutée
            if ($valide = 1) 
            {
                $erreur = "Vous avez bien ajouté vos images";
            }

            /*
             * On modifie la variable utilisée pour afficher une erreur
             * On récupère les données définies et on les insère dans la table
             */
            $valide = $valide + 1;
            $insertmbr = $bdd->prepare("INSERT INTO image(ID_Image, Utilisateur, Evenement, url) VALUES (?, ?, ?, ?)");
            $insertmbr->execute(array($checkImage ,$_SESSION['id'], $_GET['numEvent'], $new_img_name));
            $insertmbr->closeCursor();   
        }

        // On indique à l'utilisateur qu'au moins une image doit être insérée
        else
        {
            $erreur = "Veuillez mettre au moins une image";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/inscription&connexion.css" />
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>

<section id="corpus">
    <div id="formulaire">
        <h1>Ajout de photo à un evenement</h1>
        <form method="POST" enctype="multipart/form-data">
            <table id="table">
                <tr>
                    <td class="label">
                        <label for="image">Photos à ajouter :</label>
                    </td>
                    <td>
                        <input multiple="multiple" type="file" name="attachFile[]" value="rien">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input id="buttonSubmit" type="submit" name="formajout" value="Je valide" />
                    </td>
                </tr>
            </table>
            <?php
            if (isset($erreur))
                echo "<p>" . $erreur . "</p>";
            ?>
        </form>
    </div>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>