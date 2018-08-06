// Vérification de la longueur du pseudo saisi
document.getElementById("pseudo").addEventListener("input", function (e) {
    var pseudo = e.target.value;
    var regex = /^[0-9a-zA-Z]+$/;
    var pseudoLength = "insuffisante";
    var couleurMsg = "red";
    if (pseudo.length >= 5) {
        pseudoLength = "suffisante";
        couleurMsg = "green";
        if(!regex.test(pseudo)) {
            pseudoLength = " Format du pseudo non conforme (uniquement lettres et chiffres)"
            couleurMsg = "red";
        }
    }

    var aidepseudo = document.getElementById("pseudoHelpBlock");
    aidepseudo.textContent = "Longueur : " + pseudoLength; // Texte de l'aide
    aidepseudo.style.color = couleurMsg; // Couleur du texte de l'aide

});

// Vérification de la longueur du mot de passe saisi
document.getElementById("pass1").addEventListener("input", function (e) {
    var mdp = e.target.value; // Valeur saisie dans le champ mdp
    var regex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
    var longueurMdp = "Format attendu : 8 caractères minimum dont au moins 1 chiffre, un caractère spécial et sans espaces";
    var couleurMsg = "red"; // Longueur faible => couleur rouge
    if (regex.test(mdp)) {
        longueurMdp = "Format du mot de passe conforme";
        couleurMsg = "green"; // Longueur suffisante => couleur verte
    }

    var aideMdpElt = document.getElementById("passwordHelpBlock");
    aideMdpElt.textContent = "Longueur : " + longueurMdp; // Texte de l'aide
    aideMdpElt.style.color = couleurMsg; // Couleur du texte de l'aide

});

// Contrôle correspondance mdp
document.getElementById("pass2").addEventListener("input", function (e) {
    var validitepass = "";
    var inputpass1 = document.getElementById("pass1");
    var pass1 = inputpass1.value;
    if (e.target.value !== pass1) {
        // Le courriel saisi ne contient pas le caractère @
        validitepass = "Mot de passe différent, veuillez vérifier votre saisie";
        var couleurMsg = "red";
    }else{
        validitepass = "Mot de passe identique";
        var couleurMsg = "green";
    }
    var aideMdp =document.getElementById("password2HelpBlock");
    aideMdp.textContent = validitepass;
    aideMdp.style.color = couleurMsg;
});

// Contrôle du courriel
document.getElementById("email").addEventListener("input", function (e) {
    var validiteCourriel = "";
    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!regex.test(e.target.value) ) {
        // Le courriel saisi ne contient pas le caractère @
        validiteCourriel = "Adresse invalide";
        var couleurMsg = "red";
    }
    document.getElementById("emailHelpBlock").textContent = validiteCourriel;
    var aideMail =document.getElementById("emailHelpBlock");
    aideMail.textContent = validiteCourriel;
    aideMail.style.color = couleurMsg;
});