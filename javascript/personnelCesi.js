function supprimerEvenement(user,idEvent) {
    notifyBDE(user+" a supprimé l'événement d'ID "+idEvent);

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
            location.reload();
        }
    };

    xmlhttp.open("POST","scripts/addActivity.php?id="+idEvent,true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("delete=Supprimer");
}

function supprimerImage(user,idImg) {
    if (user != "") {
        notifyBDE(user+" a supprimé la photo d'ID "+idImg);
    }

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
            location.reload();
        }
    };

    xmlhttp.open("GET","scripts/manageImage.php?idImg="+idImg,true);
    xmlhttp.send();
}

function supprimerCommentaire(user,idImg, commentAuthor, idAuthor) {
    notifyBDE(user+" a supprimé le commentaire de "+commentAuthor+" sur l'image d'ID "+idImg);
    deleteComment(idImg, idAuthor);
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