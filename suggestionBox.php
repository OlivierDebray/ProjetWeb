
    <h1>Boîte à idées !</h1>
    <?php include('../Scripts/listActivity.php') ?>
    <ul>
        <?php foreach ($activities as $activity): ?>
            <li>
                <?= $activity['Nom']?> | <?= $activity['Description']?> | <?= $activity['Lieu']?>
                <a href="modifyingActivity.php?numActivity=<?= $activity['ID_Evenements']?>">Modifier</a>
                <a href="deleteActivity.php?numActivity=<?= $activity['ID_Evenements']?>">Supprimer</a>
                <a href="downloadImg.php?activityImage=<?= $activity['ID_Evenements']?>">Télécharger l'image</a>
                <a href="exportPDF.php?listParticipant=<?= $activity['ID_Evenements']?>">Liste des participants (PDF)</a>
                <a href="exportCSV.php?listParticipants=<?= $activity['ID_Evenements']?>">Liste des participants (CSV)</a>
            </li>
        <?php endforeach; ?>
    </ul>

