<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb', 'root', '');
if(isset($_POST['formajout']))
{
    $nom_produit = htmlspecialchars($_POST['nom_produit']);
    $prix = htmlspecialchars($_POST['prix']);
    $description = htmlspecialchars($_POST['description']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $stock = htmlspecialchars($_POST['stock']);
    $date = getdate();

    if (!empty($_POST['nom_produit']) AND !empty($_POST['prix']) AND !empty($_POST['description']) AND !empty($_POST['categorie']) AND !empty($_POST['stock']))
    {
        if(!empty($_FILES['imageProduits']['name']) AND isset($_FILES['imageProduits']))
        {
            $nom_produitlenght = strlen($nom_produit);
            $prixlenght = strlen($prix);
            $descriptionlenght = strlen($description);
            $categorielenght = strlen($categorie);
            $stocklenght = strlen($stock);
            

            if ($nom_produitlenght <= 50)
            {
                if ($prixlenght <= 25) 
                {
                    if ($descriptionlenght <= 255) 
                    {
                        if ($categorielenght <= 50) 
                        {
                            if ($stocklenght <= 10) 
                            {
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

<section id="corpus">
    <div id="formulaire">
        <h1>Ajout d'un produit</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <table id="table">
                <tr>
                    <td class="label">
                        <label for="nom">Nom :</label>
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
                    <tr>
                    <td class="label">
                        <label for="description">Description :</label>
                    </td>
                    <td>
                        <input class="champ" type="text" placeholder="Description du produit" id="description" name="description" value="<?php if(isset($description)) { echo $description; } ?>"/>
                    </td>
                </tr>

                <tr>
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
                        <label for="image">Image du produit :</label>
                    </td>
                    <td>
                        <input class="champ" type="file" placeholder="image du produit" id="imageProduits" name="imageProduits" value="<?php if(isset($imageProduits['name'])) { echo $imageProduits['name']; } ?>"/>
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
</body>
</html>