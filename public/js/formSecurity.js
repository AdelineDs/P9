// ---- REGISTRATION SECURITY ----

//pseudo length check
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

    let pseudoHelp = document.getElementById("pseudoHelpBlock");
    pseudoHelp.textContent = message; // help text
    pseudoHelp.style.color = colorMsg; // color help text

});

// password length check
document.getElementById("pass1").addEventListener("input", function (e) {
    let pass = e.target.value; // value of pass input
    let regex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
    let message = "Format attendu : 8 caractères minimum dont au moins 1 chiffre, un caractère spécial et sans espaces";
    let colorMsg = "red"; // low length => red color
    if (regex.test(pass)) {
        message = "ok";
        colorMsg = "green"; // good length => green color
    }

    let passHelp = document.getElementById("passwordHelpBlock");
    passHelp.textContent = message; // help text
    passHelp.style.color = colorMsg; // color help text

});

// password correspondence control
document.getElementById("pass2").addEventListener("input", function (e) {
    let passValidity = "";
    let inputpass1 = document.getElementById("pass1");
    let pass1 = inputpass1.value;
    let colorMsg = "red";
    if (e.target.value !== pass1) {
        passValidity = "Mot de passe différent, veuillez vérifier votre saisie";
    }else{
        passValidity = "Mot de passe identique";
        colorMsg = "green";
    }
    let passHelp =document.getElementById("password2HelpBlock");
    passHelp.textContent = passValidity;
    passHelp.style.color = colorMsg;
});

// mail control
document.getElementById("email").addEventListener("input", function (e) {
    let mailValidity = "";
    let regex = /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/;
    let couleurMsg = "red"
    if (!regex.test(e.target.value) ) {
        mailValidity = "Adresse invalide";
    }
    document.getElementById("emailHelpBlock").textContent = mailValidity;
    let mailHelp =document.getElementById("emailHelpBlock");
    mailHelp.textContent = mailValidity;
    mailHelp.style.color = couleurMsg;
});
