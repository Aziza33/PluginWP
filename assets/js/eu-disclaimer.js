function creerUnCookie(nomCookie, valeurCookie, dureeJours) {
    console.log("Lire cookie : " + nomCookie);

    if (dureeJours){
        var date = new Date();

        // convertit le nombre de jours spécifiés en millisecondes
        date.setTime(date.getTime() + (dureeJours * 24*60*60*1000));
        var expire = "; expire=" + date.toGMTString();
        // tester si on récupère la date
        console.log("test: Date:", date);
    }

    // si aucune valeur n'est spécifiée 
    else{
        let expire = "";

    }
    document.cookie = nomCookie + "=" + valeurCookie + expire + "; path=/";
} //RAJOUT A VERIFIER

    // Pour lire le cookie

    function lireUnCookie(nomCookie) {
console.log("Lire cookie 2 : " + nomCookie);
        // ajoute un signe égal au nom pour la recherche dans le tableau contenant tous les cookies
        var nomFormate = nomCookie + "=";

        // tableau contenant tous les cookies
        var tableauCookies = document.cookie.split(';');
        
        // MODE ES6
        // const cookieFind =  tableauCookies.find(cookie => {
        //     return cookie.trim().includes(nomCookie, 0)
        // })
        // return cookieFind ? cookieFind.substring(nomFormate.length + 1) : null;

        // const cookieFind =  tableauCookies.find(cookie => cookie.trim().includes(nomCookie, 0))
        // return cookieFind ? cookieFind.substring(nomFormate.length + 1) : null;

        // recherche dans le tableau le cookie en question
        for (var i = 0; i < tableauCookies.length; i++){
            var cookieTrouve = tableauCookies[i];

            // tant qu'on trouve un espace on le supprime 
            while (cookieTrouve.charAt(0) == ' ') {
                cookieTrouve = cookieTrouve.substring(1, cookieTrouve.length);
            }
            if (cookieTrouve.indexOf(nomFormate) == 0) {
                return cookieTrouve.substring(nomFormate.length, cookieTrouve.length);
            }

        }
        // on retourne une valeur nulle si aucun cookie n'est trouvé
        return null;
    }
    

    document.getElementById("actionDisclaimer").addEventListener("click", accepterLeDisclaimer);

// création d'une  fonction que nous allons lier au bouton oui du modal par le biais de la fonction onclick
    // résultat : au click du bouton la fonction "accepterLeDisclaimer" va appeler la fonction "creerUnCookie" et la valeur du cookie devrait s'afficher
    // dans la console du navigateur
    function accepterLeDisclaimer(){
        creerUnCookie('eu-disclaimer-vapobar', "ejD86j7ZXF3x", 1);
        var cookie = lireUnCookie('eu-disclaimer-vapobar');
        console.log("test cookie créé", cookie);
        alert(cookie);
    }
//}

jQuery(document).ready(function($){
    if(lireUnCookie('eu-disclaimer-vapobar') !="ejD86j7ZXF3x"){
        $("#monModal").modal({
            escapeClose: false,
            clickClose: false,
            showClose: false
        });
    }
});

