function likeIdea (idUser , idIdea , likeCount) {
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
    xmlhttp.open("GET","scripts/likeIdea.php?idea="+idIdea+"&user="+idUser,true);
    xmlhttp.send();

    document.getElementById("like"+idIdea).textContent = (likeCount+1)+" like(s)";
}