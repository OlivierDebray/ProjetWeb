function supprimerEvenement(user,idEvent) {
    notifyBDE(user+" a supprimé l'événement d'ID "+idEvent);
}

function supprimerImage(user,idImg) {
    notifyBDE(user+" a supprimé la photo d'ID "+idImg);
}

function supprimerCommentaire(user,idComment) {
    notifyBDE(user+" a supprimé le commentaire d'ID "+idComment);
}

function notifyBDE(message) {
    // On prépare un objet XMLHttpRequest
    if (window.XMLHttpRequest) {
        // Code pour IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // Code pour IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        }
    };

    xmlhttp.open("POST","scripts/sendNotificationBDE.php",true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("message="+message);
}