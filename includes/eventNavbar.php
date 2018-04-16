<nav id="secondary">
    <a href="listeEvenements.php?page=avenir">Evénements à venir</a>
    <a href="listeEvenements.php?page=passes">Evénements passés</a>
    <a href="boiteAIdee.php">Boite à idées</a>
    <?php if (isset($_SESSION['etat']) AND ($_SESSION['etat'] == 1)) { ?>
        <a href="addEvent.php">Ajouter un événement</a>
    <?php } ?>
</nav>