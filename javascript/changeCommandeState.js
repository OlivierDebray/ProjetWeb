function changeCommandeState (idCommande) {
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

    xmlhttp.open("GET","commandes.php?id="+idCommande,true);
    xmlhttp.send();

    var button = document.getElementById("button"+idCommande);
    button.parentNode.removeChild(button);

    var para = document.getElementById("para"+idCommande);
    para.parentNode.removeChild(para);

    var commandesLivrees = document.getElementById("commandesLivrees");

    commandesLivrees.appendChild(para);

}