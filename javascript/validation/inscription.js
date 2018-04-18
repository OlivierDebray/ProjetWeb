function verifLength(champ,length)
{
    if(champ.value.length > length)
    {
        surligne(champ, true);
        var newLabel = createLabel("La longueur de \""+champ.name+"\" doit être inférieure à "+length,champ.name);
        document.getElementById("paraErreur").appendChild(newLabel);
        return false;
    }
    else
    {
        surligne(champ, false);
        var labelChamp = document.getElementById("label"+champ.name);
        labelChamp.parentNode.removeChild(labelChamp);
        return true;
    }
}

function verifMail(champ,champ2)
{
    var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
    if(!regex.test(champ.value))
    {
        surligne(champ, true);
        var newLabel = createLabel("L'adresse doit être de la forme ***@***.***",champ.name);
        document.getElementById("paraErreur").appendChild(newLabel);
        return false;
    }
    else
    {
        surligne(champ, false);
        var labelChamp = document.getElementById("label"+champ.name);
        labelChamp.parentNode.removeChild(labelChamp);

        if (champ.value != champ2.value) {
            surligne(champ, true);
            surligne(champ2, true);
            var newLabel = createLabel("Les deux adresses mail doivent être identiques",champ.name);
            document.getElementById("paraErreur").appendChild(newLabel);
            return false;
        }
        else {
            surligne(champ, false);
            surligne(champ2, false);
            var labelChamp = document.getElementById("label"+champ.name);
            labelChamp.parentNode.removeChild(labelChamp);
            var labelChamp = document.getElementById("label"+champ2.name);
            labelChamp.parentNode.removeChild(labelChamp);
        }

        return true;
    }
}

function surligne(champ, erreur)
{
    if(erreur)
        champ.style.backgroundColor = "#fba";
    else
        champ.style.backgroundColor = "";
}

function createLabel(text,id)
{
    if (document.getElementById("label"+id) == null) {
        var newLabel = document.createElement('p');
        newLabel.id = "label"+id;
        newLabel.textContent = text;

        return newLabel;
    }
}