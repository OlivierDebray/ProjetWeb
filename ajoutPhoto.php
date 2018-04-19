<?php
session_start();

$valide = 1;
$date = getdate();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb', 'root', '');
if(isset($_POST['formajout']))
{

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


    $file_ary = reArrayFiles($_FILES['attachFile']); 
    foreach($file_ary as $file)
    {
        $tmp_name = $file['tmp_name'];
        $type = $file['type'];
        $name = $file['name'];
        $size = $file['size'];

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

            if(in_array($image_extension, $allowed))
            {
                move_uploaded_file($tmp_name,$target);
            }
            if ($valide = 1) 
            {
                $erreur = "Vous avez bien ajouté vos images";
            }

            $valide = $valide + 1;
            $insertmbr = $bdd->prepare("INSERT INTO image(ID_Image, Utilisateur, Evenement, url) VALUES (?, ?, ?, ?)");
            $insertmbr->execute(array($checkImage ,$_SESSION['id'], $_GET['numEvent'], $new_img_name));
            $insertmbr->closeCursor();   
        } 
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