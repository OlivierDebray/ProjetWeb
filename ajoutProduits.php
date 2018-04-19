<?php
//On se connecte a la bdd
$bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb;charset=utf8', 'root', '');

//Si on appuie sur le bouton "je valide", alors on récupère les informations des champs du formulaire
if(isset($_POST['formajout']))
{
    $nom_produit = htmlspecialchars($_POST['nom_produit']);
    $prix = htmlspecialchars($_POST['prix']);
    $description = htmlspecialchars($_POST['description']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $stock = htmlspecialchars($_POST['stock']);
    $date = getdate();

    //On regarde si les champs ont bien été rempli
    if (!empty($_POST['nom_produit']) AND !empty($_POST['prix']) AND !empty($_POST['description']) AND !empty($_POST['categorie']) AND !empty($_POST['stock']))
    {
        //Si on a bien ajoute une image
        if(!empty($_FILES['imageProduits']['name']) AND isset($_FILES['imageProduits']))
        {
            //on stock la longueur des informations
            $nom_produitlenght = strlen($nom_produit);
            $prixlenght = strlen($prix);
            $descriptionlenght = strlen($description);
            $categorielenght = strlen($categorie);
            $stocklenght = strlen($stock);

            //si le nom du produit est inferieur a 50 ou egal charactere
            if ($nom_produitlenght <= 50)
            {
                //si le prix du produit est inferieur ou egal a 25 charactere
                if ($prixlenght <= 25) 
                {
                    //si la description est inferieur ou égal a 255 charactere
                    if ($descriptionlenght <= 255) 
                    {
                        //si la categorie est inferieur ou egal à 50 charactere
                        if ($categorielenght <= 50) 
                        {
                            //si le stock est inferieur ou egal à 10 produits
                            if ($stocklenght <= 10) 
                            {
                                //on prepare toutes les variables à ajouter dans la bdd
                                $image = $_FILES['imageProduits'];
                                $tmpname = $image['tmp_name'];
                                $extension = explode('.', $image['name']);
                                $image_extension = strtolower(end($extension));
                                $allowed = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'bmp');
                                $new_img_name = $date['mday'].$date['mon'].$date['year'].'_'.$date['hours'].$date['minutes'].$date['seconds'].".".$image_extension;
                                $target = "images/produits/".$new_img_name;
                                if(in_array($image_extension, $allowed))
                                {
                                    move_uploaded_file($tmpname,$target);
                                }
                                //on insert les informations dans la bdd
                                $insertmbr = $bdd->prepare("INSERT INTO produits(nom, prix, description, categorie ,stock, dateajout, url) VALUES (?, ?, ?, ?, ?, ?,?)");
                                $insertmbr->execute(array($nom_produit, $prix, $description, $categorie ,$stock, date("Y-m-d"), $new_img_name));
                                $erreur = "Le produit a bien été ajouté !";
                            }
                            else 
                            {
                                $erreur = "le stock ne doit pas dépasser 10 caractères !";
                            }
                        }
                        else
                        {
                            $erreur = "la categorie ne doit pas dépasser 50 caractères !";
                        }
                    }
                    else
                    {
                        $erreur = "la description du produit ne doit pas dépasser 255 caractères !";
                    }   
                }
                else
                {
                    $erreur = "le prix du produit ne doit pas dépasser 25 caractères !";
                }

                    
            }
            else
            {
                $erreur = "le nom du produit ne doit pas dépasser 50 caractères !";
            }
        }
        else
        {
            $erreur = "Vous devez obligatoirement ajouter une image !";
        }
    }
    else
    {
        $erreur = "Tous les champs doivent être complétés !";    
    }
}

?>

<?php session_start() ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/inscription&connexion.css" />
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>
<?php include ('includes/shopNavbar.php') ?>

<section id="corpus">
    <div id="formulaire">
        <h1>Ajout d'un produit</h1>
        <form method="POST" enctype="multipart/form-data">
            <table id="table">
                <tr>
                    <td class="label">
                        <label for="nom_produit">Nom :</label>
                    </td>
                    <td>
                        <input class="champ" type="text" placeholder="Nom du produit" id="nom_produit" name="nom_produit" value="<?php if(isset($nom_produit)) { echo $nom_produit; } ?>"/>
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        <label for="prix">Prix :</label>
                    </td>
                    <td>
                        <input class="champ" type="text" placeholder="Prix du produit" id="prix" name="prix" value="<?php if(isset($prix)) { echo $prix; } ?>"/>
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        <label for="description">Description :</label>
                    </td>
                    <td>
                        <input class="champ" type="text" placeholder="Description du produit" id="description" name="description" value="<?php if(isset($description)) { echo $description; } ?>"/>
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        <label for="categorie">Categorie :</label>
                    </td>
                    <td>
                        <input class="champ" type="text" placeholder="Categorie du produit" id="categorie" name="categorie" value="<?php if(isset($categorie)) { echo $categorie; } ?>"/>
                    </td> 
                </tr>                   

                <tr>
                    <td class="label">
                        <label for="stock">Stock :</label>
                    </td>
                    <td>
                        <input class="champ" type="text" placeholder="Stock du produit" id="stock" name="stock" value="<?php if(isset($stock)) { echo $stock; } ?>"/>
                    </td>
                </tr>

                <tr>
                    <td class="label">
                        <label for="imageProduits">Image du produit :</label>
                    </td>
                    <td>
                        <input class="champ" type="file" id="imageProduits" name="imageProduits" /> <!--value="<?php // if(isset($imageProduits['name'])) { echo $imageProduits['name']; } ?>"-->
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
            // lorsque qu'on arrive pas a rentrer dans une boucle on affiche l'erreur correspondante
            if (isset($erreur))
                echo "<p>" . $erreur . "</p>";
            ?>

        </form>
    </div>
</section>

<?php include ('includes/footer.php')?>
</body>
</html>