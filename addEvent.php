<?php session_start() ?>

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
    <form method="POST" action="scripts/addActivity.php?idUser=1" autocomplete="on" enctype="multipart/form-data">
        <p>
            <label for="event">
                Titre :
            </label>
            <input type="text" name="event" id="event" placeholder="Ex: Laser Game" />
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
                <input type="radio" id="dateChoice1" name="dateChoice" value="ponctuelle">
                <label for="dateChoice1">Ponctuelle</label>

                <input type="radio" id="dateChoice2" name="dateChoice" value="recurrente">
                <label for="dateChoice2">Récurrente</label>
            </span>
        </p>
        <p>
            <span>
                <input type="radio" id="prixChoice1" name="prixChoice" value="gratuite" onclick="document.getElementById('prixSelector').style.visibility = 'hidden'">
                <label for="prixChoice1">Gratuite</label>

                <input type="radio" id="prixChoice2" name="prixChoice" value="payante" onclick="document.getElementById('prixSelector').style.visibility = 'visible'">
                <label for="prixChoice2">Payante</label>
            </span>

            <span id="prixSelector" style="visibility: hidden"><input type="number" step="0.01" min="0" placeholder="Prix">€</span>
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
            <input type="submit" name="upload" value='Envoyer' />
        </p>
    </form>
</section>

<?php include('includes/footer.php') ?>

</body>
</html>