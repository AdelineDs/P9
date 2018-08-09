let $grid = $('.grid').imagesLoaded( function() {
    // init Masonry after all images have loaded
    $grid.masonry({
        itemSelector: '.grid-item',
        percentPosition: true,
        columnWidth: '.grid-sizer'
    });
});

let myMap = new leafletMap("map");
myMap.photoRecovery("index.php?action=getPictures");