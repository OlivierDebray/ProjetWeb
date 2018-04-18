function addToCart (idProduit) {
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

        }
    };

    xmlhttp.open("GET","AjoutBDDpanier.php?idproduit="+idProduit,true);
    xmlhttp.send();

    document.getElementById("label"+idProduit).textContent = "Produit ajouté !";
}

function removeFromCart (idProduit) {
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
            
        }
    };

    xmlhttp.open("GET","supprimerpanier.php?id="+idProduit,true);
    xmlhttp.send();

    var row = document.getElementById("row"+idProduit);
    row.parentNode.removeChild(row);
}