function deleteNotification (idNotif) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET","scripts/deleteNotification.php?id="+idNotif,true);
    xmlhttp.send();

    var divNotif = document.getElementById("divNotif"+idNotif);
    divNotif.parentNode.removeChild(divNotif);
}