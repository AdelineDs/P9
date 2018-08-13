class ControllerAjax {

    constructor(latMin, latMax, lngMin, lngMax, photosArray) {
        this.latMin = latMin;
        this.latMax = latMax;
        this.lngMin = lngMin;
        this.lngMax = lngMax;
        this.photosArray = photosArray
        this.phpcontroller = "?action=";
        this.searchAroundPhotos(this.latMin, this.latMax, this.lngMin, this.lngMax, this.photosArray);
    }//-- end contructor --
    //
    //cherche les photos présente dans les limites de la carte
    searchAroundPhotos(latMin, latMax, lngMin, lngMax, photosArray) {
        $.ajax({
            url: this.phpcontroller + "getAroundPhotos",
            method: 'GET',
            data: {
                "latMin": latMin,
                "latMax": latMax,
                "lngMin": lngMin,
                "lngMax": lngMax,
                "photosArray": JSON.stringify(photosArray)
            },
            success: (data) => {
                if (data == "Error") {
                    alert("Requête corrompue");
                }
                else {
                    $(".empty").remove();
                    $('.MS-controls').show();
                    document.getElementById('slider').innerHTML = "";
                    $("#slider").append(data);
                }
            }
        });
    }//-- end searchArroundPhoto --
}//---- end Class ControllerAjax ----