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

    xmlhttp.open("GET","scripts/inscription.php?user="+idUser+"&event="+idEvent+"&participation="+participation,true);
    xmlhttp.send();

    var buttonText = "";

    if (participation == 0) {
        buttonText = "Se désinscrire";
        participation = 1;
    }
    else if (participation == 1) {
        buttonText = "S'inscrire";
        participation = 0;
    }

    document.getElementById("button"+idEvent).textContent = buttonText;

    document.getElementById("button"+idEvent).onclick = function () {
        inscription(idUser , idEvent , participation);
    };
}