function addComment(idPhoto, idUser) {
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
            location.reload();
        }
    };

    var textArea = document.getElementById("textarea"+idPhoto);

    xmlhttp.open("POST","scripts/manageComment.php",true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("photo="+idPhoto+"&user="+idUser+"&message="+textArea.value);
}

function deleteComment(idPhoto, idUser) {
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
            location.reload();
        }
    };

    xmlhttp.open("POST","scripts/manageComment.php",true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("photo="+idPhoto+"&user="+idUser+"&mode=delete");
}