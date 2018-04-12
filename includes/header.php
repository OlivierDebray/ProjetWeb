<header>
    <div id="en-tete">
        <a href="index.php"><img id="logo" src="images/logo.png" alt="Logo Exia Cesi" /></a>
        <?php
        if (isset($_SESSION['id']))
            echo '<p>' . $_SESSION['prenom'] . ' ' . $_SESSION['nom'] . '|' . '<a href="scripts/deconnexion.php">Déconnexion</a>' . '</p>';
        else
            echo '<p><a href="connexion.php">Connexion</a> | <a href="inscription.php">Inscription</a></p>';
        ?>
    </div>
</header>