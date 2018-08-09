class ControllerAjax {

    constructor(latMin, latMax, lngMin, lngMax) {
        this.latMin = latMin;
        this.latMax = latMax;
        this.lngMin = lngMin;
        this.lngMax = lngMax;
        this.phpcontroller = "?action=";
        this.searchAroundPhotos(this.latMin, this.latMax, this.lngMin, this.lngMax);
    }//-- end contructor --
    //
    //cherche les photos présente dans les limites de la carte
    searchAroundPhotos(latMin, latMax, lngMin, lngMax) {
        $.ajax({
            url: this.phpcontroller + "getAroundPhotos",
            method: 'GET',
            data: {
                "latMin": latMin,
                "latMax": latMax,
                "lngMin": lngMin,
                "lngMax": lngMax
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