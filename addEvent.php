<?php session_start();

if (isset($_POST['formAddEvent'])) {

    $bdd = new PDO('mysql:host=127.0.0.1;dbname=projetweb;charset=utf8', 'root', '');

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

    if ($prixChoice == "gratuite") {
        $prix = $prixChoice;
    }

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

    $requete = $bdd->prepare("INSERT INTO evenements (Nom, UtilisateurCreateur, Description, Date, Lieu, Image, Etat, Payant) VALUES( :event, :userCreator, :description, :date, :location, :image, 1, :prix)");
    $requete->bindValue(':event', $event, PDO::PARAM_STR);
    $requete->bindValue(':userCreator', $_SESSION['id'], PDO::PARAM_STR);
    $requete->bindValue(':description', $description, PDO::PARAM_STR);
    $requete->bindValue(':location', $location, PDO::PARAM_STR);
    $requete->bindValue(':image', '/'.$new_img_name, PDO::PARAM_STR);
    $requete->bindValue(':prix', $prix, PDO::PARAM_STR);

    if ($dateChoice == "recurrente") {
        for ($i = 0 ; $i < $recurrence ; $i++) {
            $requete->bindValue(':date', $date, PDO::PARAM_STR);
            $requete->execute();

            $date = date('Y-m-d', strtotime($date . ' + '.$recurrence2.' '.$recurrence3));
        }
    } else {
        $requete->bindValue(':date', $date, PDO::PARAM_STR);
        $requete->execute();
    }

    $requete->closeCursor();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
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
    <form method="POST" action="" autocomplete="on" enctype="multipart/form-data">
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