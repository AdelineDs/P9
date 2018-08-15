// ---- MASONRY ----
let $grid = $('.grid').imagesLoaded( function() {
    // init Masonry after all images have loaded
    $grid.masonry({
        itemSelector: '.grid-item',
        percentPosition: true,
        columnWidth: '.grid-sizer'
    });
});

// ---- INIT MAP ----
let myMap = new leafletMap("map");
myMap.photoRecovery("index.php?action=getPictures");

// ---- REGISTRATION SECURITY ----
// Vérification de la longueur du pseudo saisi
document.getElementById("pseudo").addEventListener("input", function (e) {
    let pseudo = e.target.value;
    let regex = /^[0-9a-zA-Z]+$/;
    let pseudoLength = "insuffisante";
    let couleurMsg = "red";
    if (pseudo.length >= 5) {
        pseudoLength = "suffisante";
        couleurMsg = "green";
        if(!regex.test(pseudo)) {
            pseudoLength = " Format du pseudo non conforme (uniquement lettres et chiffres)"
            couleurMsg = "red";
        }
    }

    let aidepseudo = document.getElementById("pseudoHelpBlock");
    aidepseudo.textContent = "Longueur : " + pseudoLength; // Texte de l'aide
    aidepseudo.style.color = couleurMsg; // Couleur du texte de l'aide

});

// Vérification de la longueur du mot de passe saisi
document.getElementById("pass1").addEventListener("input", function (e) {
    let mdp = e.target.value; // Valeur saisie dans le champ mdp
    let regex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
    let longueurMdp = "Format attendu : 8 caractères minimum dont au moins 1 chiffre, un caractère spécial et sans espaces";
    let couleurMsg = "red"; // Longueur faible => couleur rouge
    if (regex.test(mdp)) {
        longueurMdp = "Format du mot de passe conforme";
        couleurMsg = "green"; // Longueur suffisante => couleur verte
    }

    let aideMdpElt = document.getElementById("passwordHelpBlock");
    aideMdpElt.textContent = "Longueur : " + longueurMdp; // Texte de l'aide
    aideMdpElt.style.color = couleurMsg; // Couleur du texte de l'aide

});

// Contrôle correspondance mdp
document.getElementById("pass2").addEventListener("input", function (e) {
    let validitepass = "";
    let inputpass1 = document.getElementById("pass1");
    let pass1 = inputpass1.value;
    if (e.target.value !== pass1) {
        // Le courriel saisi ne contient pas le caractère @
        validitepass = "Mot de passe différent, veuillez vérifier votre saisie";
        let couleurMsg = "red";
    }else{
        validitepass = "Mot de passe identique";
        let couleurMsg = "green";
    }
    let aideMdp =document.getElementById("password2HelpBlock");
    aideMdp.textContent = validitepass;
    aideMdp.style.color = couleurMsg;
});

// Contrôle du courriel
document.getElementById("email").addEventListener("input", function (e) {
    let validiteCourriel = "";
    let regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!regex.test(e.target.value) ) {
        // Le courriel saisi ne contient pas le caractère @
        validiteCourriel = "Adresse invalide";
        let couleurMsg = "red";
    }
    document.getElementById("emailHelpBlock").textContent = validiteCourriel;
    let aideMail =document.getElementById("emailHelpBlock");
    aideMail.textContent = validiteCourriel;
    aideMail.style.color = couleurMsg;
});

