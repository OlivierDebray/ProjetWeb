// Fonction asynchrone d'inscription à un événement
// Paramètres : IDs de l'utilisateur et de l'événement, variable décrivant si l'utilisateur est déjà inscrit (O ou 1)
function inscription(idUser, idEvent, participation) {
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

    // On ouvre l'objet XMLHttpRequest sur le script PHP inscription avec les trois paramètres
    xmlhttp.open("GET","scripts/inscription.php?user="+idUser+"&event="+idEvent+"&participation="+participation,true);
    xmlhttp.send();

    var buttonText = "";

    // Si l'utilisateur est déjà inscrit ou non, on adapte les variables
    if (participation == 0) {
        buttonText = "Se désinscrire";
        participation = 1;
    }
    else if (participation == 1) {
        buttonText = "S'inscrire";
        participation = 0;
    }

    // On applique le changement du texte du bouton
    document.getElementById("button"+idEvent).textContent = buttonText;

    // On met à jour l'appel de la fonction lorsque l'on appuie sur le bouton
    document.getElementById("button"+idEvent).onclick = function () {
        inscription(idUser , idEvent , participation);
    };
}