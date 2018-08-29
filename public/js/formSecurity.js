// ---- REGISTRATION SECURITY ----

// Vérification de la longueur du pseudo saisi
document.getElementById("pseudo").addEventListener("input", function (e) {
    let pseudo = e.target.value;
    let regex = /^[0-9a-zA-Z]+$/;
    let message = "Longueur insuffisante";
    let colorMsg = "red";
    if (pseudo.length >= 4) {
        message = "ok";
        colorMsg = "green";
        if(!regex.test(pseudo)) {
            message = "Format du pseudo non conforme (uniquement lettres et chiffres)"
            colorMsg = "red";
        }
    }

    let aidepseudo = document.getElementById("pseudoHelpBlock");
    aidepseudo.textContent = message; // Texte de l'aide
    aidepseudo.style.color = colorMsg; // Couleur du texte de l'aide

});

// Vérification de la longueur du mot de passe saisi
document.getElementById("pass1").addEventListener("input", function (e) {
    let mdp = e.target.value; // Valeur saisie dans le champ mdp
    let regex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
    let message = "Format attendu : 8 caractères minimum dont au moins 1 chiffre, un caractère spécial et sans espaces";
    let colorMsg = "red"; // Longueur faible => couleur rouge
    if (regex.test(mdp)) {
        message = "ok";
        colorMsg = "green"; // Longueur suffisante => couleur verte
    }

    let aideMdpElt = document.getElementById("passwordHelpBlock");
    aideMdpElt.textContent = message; // Texte de l'aide
    aideMdpElt.style.color = colorMsg; // Couleur du texte de l'aide

});

// Contrôle correspondance mdp
document.getElementById("pass2").addEventListener("input", function (e) {
    let validitepass = "";
    let inputpass1 = document.getElementById("pass1");
    let pass1 = inputpass1.value;
    let colorMsg = "red";
    if (e.target.value !== pass1) {
        // Le courriel saisi ne contient pas le caractère @
        validitepass = "Mot de passe différent, veuillez vérifier votre saisie";
    }else{
        validitepass = "Mot de passe identique";
        colorMsg = "green";
    }
    let aideMdp =document.getElementById("password2HelpBlock");
    aideMdp.textContent = validitepass;
    aideMdp.style.color = colorMsg;
});

// Contrôle du courriel
document.getElementById("email").addEventListener("input", function (e) {
    let validiteCourriel = "";
    let regex = /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/;
    let couleurMsg = "red"
    if (!regex.test(e.target.value) ) {
        // Le courriel saisi ne contient pas le caractère @
        validiteCourriel = "Adresse invalide";
    }
    document.getElementById("emailHelpBlock").textContent = validiteCourriel;
    let aideMail =document.getElementById("emailHelpBlock");
    aideMail.textContent = validiteCourriel;
    aideMail.style.color = couleurMsg;
});
