<?php // Page et script d'ajout d'un événement par le membre du BDE
session_start();

// Si le formulaire a été envoyé sur la page
if (isset($_POST['formAddEvent'])) {

    $bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb;charset=utf8', 'root', '');

    // Les différentes entrées du formulaire
    $event = $_POST['event'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $dateChoice = $_POST['dateChoice'];
    $prixChoice = $_POST['prixChoice'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];
    $recurrence = $_POST['recurrence'];
    $recurrence2 = $_POST['recurrence2'];
    $recurrence3 = $_POST['recurrence3'];

    // Si l'événement est gratuit, $prix prend la valeur "gratuite"
    if ($prixChoice == "gratuite") {
        $prix = $prixChoice;
    }

    // On récupère et l'on traite l'image envoyé par le formulaire
    if(!empty($_FILES['image']['name']) AND isset($_FILES['image'])){
        $image = $_FILES['image'];
        $tmpname = $image['tmp_name'];
        $extension = explode('.', $image['name']);
        $image_extension = strtolower(end($extension));
        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
        $dateNow = getdate();
        $new_img_name = $dateNow['mday'].$dateNow['mon'].$dateNow['year'].'_'.$dateNow['hours'].$dateNow['minutes'].$dateNow['seconds'].'.'.$image_extension;
        $target = "images/Suggestionbox/".$new_img_name;

        if(in_array($image_extension, $allowed)){
            move_uploaded_file($tmpname,$target);
        }
    } else {
        $new_img_name = "activity.png";
    }

    // On prépare la requête et l'on assigne la plupart des paramètres
    $requete = $bdd->prepare("INSERT INTO evenements (Nom, UtilisateurCreateur, Description, Date, Lieu, Image, Etat, Payant) VALUES( :event, :userCreator, :description, :date, :location, :image, 1, :prix)");
    $requete->bindValue(':event', $event, PDO::PARAM_STR);
    $requete->bindValue(':userCreator', $_SESSION['id'], PDO::PARAM_STR);
    $requete->bindValue(':description', $description, PDO::PARAM_STR);
    $requete->bindValue(':location', $location, PDO::PARAM_STR);
    $requete->bindValue(':image', '/'.$new_img_name, PDO::PARAM_STR);
    $requete->bindValue(':prix', $prix, PDO::PARAM_STR);

    if ($dateChoice == "recurrente") {  // Si l'événement est récurrent ...
        // On boucle autant de fois qu'il y a d'occurences de l'événement ...
        for ($i = 0 ; $i < $recurrence ; $i++) {
            // On assigne la date à la requête préparée et l'on exécute la requête
            $requete->bindValue(':date', $date, PDO::PARAM_STR);
            $requete->execute();

            // On incrémente la date selon l'écart spécifié par l'utilisateur (ex: ' + 2 weeks', ' + 1 months'
            $date = date('Y-m-d', strtotime($date . ' + '.$recurrence2.' '.$recurrence3));
        }
    } else {    // Sinon, si l'événement est ponctuel, on assigne la date du formulaire et l'on exécute la requête
        $requete->bindValue(':date', $date, PDO::PARAM_STR);
        $requete->execute();
    }

    $requete->closeCursor();
}

// Ci-dessous, le code html de la page d'ajout d'un événement, accessible uniquement par les membres du BDE
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Ajout d'un événement | BDE Exia Orléans</title>
    <?php include('includes/head.php') ?>
    <link rel="stylesheet" type="text/css" href="css/boiteAIdee.css"/>
    <script src="javascript/likeEvent.js"></script>
</head>
<body>
<?php include('includes/header.php') ?>

<?php include('includes/mainNavbar.php') ?>
<?php include('includes/eventNavbar.php') ?>

<section id="corpus">
    <h1>Ajout d'un d'événement</h1>
    <form method="POST" autocomplete="on" enctype="multipart/form-data">
        <p>
            <label for="event">
                Titre :
            </label>
            <input type="text" name="event" id="event" placeholder="Ex: Laser Game" required/>
            &nbsp;
            <label for="location">
                Lieu :
            </label>
            <input type="text" name="location" id="location" placeholder="Ex: Orléans" />
        </p>
        <p>
            <label for="date">Date :</label>
            <input type="date" name="date" id="date" required/>

            <span>
                <input required type="radio" id="dateChoice1" name="dateChoice" value="ponctuelle" onclick="document.getElementById('recurrenceSelector').style.visibility = 'hidden'; ">
                <label for="dateChoice1">Ponctuelle</label>

                <input type="radio" id="dateChoice2" name="dateChoice" value="recurrente" onclick="document.getElementById('recurrenceSelector').style.visibility = 'visible';">
                <label for="dateChoice2">Récurrente</label>

                <span style="visibility: hidden" id="recurrenceSelector">
                    <input name="recurrence" type="number" min="2" placeholder="Nbre d'occurences">
                    fois, tous/toutes les
                    <input name="recurrence2" type="number" min="1" placeholder="Ecart entre occurences">
                    <select name="recurrence3">
                        <option value="weeks">Semaine</option>
                        <option value="months">Mois</option>
                    </select>
                </span>
            </span>
        </p>
        <p>
            <span>
                <input required type="radio" id="prixChoice1" name="prixChoice" value="gratuite" onclick="document.getElementById('prixSelector').style.visibility = 'hidden'">
                <label for="prixChoice1">Gratuite</label>

                <input type="radio" id="prixChoice2" name="prixChoice" value="payante" onclick="document.getElementById('prixSelector').style.visibility = 'visible'">
                <label for="prixChoice2">Payante</label>
            </span>

            <span id="prixSelector" style="visibility: hidden"><input name="prix" type="number" step="0.01" min="0" placeholder="Prix" value="0">€</span>
        </p>
        <p>
            <label for="description">
                Description (255 caractères maximum) :
            </label>
            <br/>
            <textarea name="description" id="description" maxlength="255"></textarea>
        </p>
        <p>
            Image :
            <input type="file" name="image"/>
        </p>
        <p>
            <input type="submit" name="formAddEvent" value='Envoyer' />
        </p>
    </form>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>