// Fonction asynchrone d'ajout/suppression de likes
// Paramètres : IDs de l'utilisateur, de l'événement, nombre de likes total, variable permettant de savoir si
// l'utilisateur a déjà liké l'événement (0 ou 1), et type d'événement (idea ou event)
function likeEvent (idUser , idEvent , likeCount , userLike, eventType) {
    // On prépare un objet XMLHttpRequest
    if (window.XMLHttpRequest) {
        // Code pour IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // Code pour IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
        }
    };

    // Appel du script PHP likeEvent et passage en GET des différents paramètres
    xmlhttp.open("GET","scripts/likeEvent.php?event="+idEvent+"&user="+idUser+"&userLike="+userLike+"&eventType="+eventType,true);
    xmlhttp.send();

    // Si l'utilisateur n'avait pas déjà liké, on passe la variable userLike à 1 et on incrémente le total de likes
    if (userLike == 0) {
        likeCount++;
        userLike = 1;
    }
    // Si l'utilisateur avait déjà liké, on effectue l'inverse
    else {
        likeCount--;
        userLike = 0
    }

    // On applique ce changement de valeur au document
    document.getElementById("like"+idEvent).textContent = likeCount +" like(s)";

    // On change les paramètres d'appel de cette fonction pour cet événement
    document.getElementById("img"+idEvent).onclick = function () {
        likeEvent(idUser , idEvent , likeCount , userLike);
    };
}