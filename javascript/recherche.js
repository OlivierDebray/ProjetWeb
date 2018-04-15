/**
 * Created by Théo on 13/04/2018.
 */
var liste = [
    "T-shirt",
    "Drapeau",
    "Mug",
    "Goodies"

];

var listeElt = document.querySelector("input");
var suggestionsElt = document.getElementById("suggestions");

// Gère le changement de valeur saisie

listeElt.addEventListener("input", function ()
{
    suggestionsElt.innerHTML = ""; // Vidage de la liste des suggestions



    liste.forEach(function (nom)
    {
        // Si valeur en cours de saisie correspond au début du pays

        if (nom.indexOf(listeElt.value) === 0)
        {
            var suggestionElt = document.createElement("div");
            suggestionElt.classList.add("suggestion");

            suggestionElt.textContent = nom;

            // Gère le lic sur une suggestion

            suggestionElt.addEventListener("click", function (e)

            {
                // Remplacement de la valeur saisie par la suggestion
                listeElt.value = e.target.textContent;

                // Vidage de la liste des suggestions
                suggestionsElt.innerHTML = "";
            });

            suggestionsElt.appendChild(suggestionElt);
        }
    });
});
