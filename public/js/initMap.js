// ---- INIT MAP ----
let myMap = new leafletMap("map");
myMap.photoRecovery("index.php?action=getPictures");

let slide = document.getElementById('rslides');
console.log(slide.innerHTML);

document.on('click', () => {
    if (slide.innerHTML != ""){
        $(".textMap").hide();
    }
})
