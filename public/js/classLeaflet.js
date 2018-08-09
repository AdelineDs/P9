class leafletMap{
    constructor(map, latLng=[48.862725, 2.287592], zoom=6, layer='https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',minZoom=6, maxZoom=11){
        this.map = map;
        this.latLng = latLng;
        this.zoom = zoom;
        this.layer = layer;
        this.minZoom = minZoom;
        this.maxZoom = maxZoom;
        this.myMap = L.map(this.map).setView(this.latLng,this.zoom);
        this.markersCluster = L.markerClusterGroup();



        L.tileLayer(this.layer, {minZoom: this.minZoom, maxZoom: this.maxZoom}).addTo(this.myMap);

        this.myMap.addLayer(this.markersCluster);
    }//-- end constructor --

    photoRecovery(source) {
        ajaxGet(source, reponse => {
            let photosList = JSON.parse(reponse);
            let takenIds =[];
            let addedImage = false;
            for(let i=0; i < photosList.length; i++){
                let photo = photosList[i];
                let photoGallery =[];
                for (let j=i; j < photosList.length; j++){
                    let picture = photosList[j];
                    if(!this.contains.call(takenIds, photo.id)){
                        photoGallery.push(photo);
                        takenIds.unshift(photo.id);
                        addedImage = true;
                    }
                    if(photo.lat == picture.lat && photo.lng == picture.lng){
                        if(!this.contains.call(takenIds, picture.id)){
                            photoGallery.push(picture);
                            takenIds.push(picture.id);
                        }
                    }
                }//-- end for --
                if(addedImage){
                    takenIds.shift();
                    addedImage = false;
                }
                let latLng = new L.LatLng(photo.lat, photo.lng);
                if(!this.contains.call(takenIds, photo.id)){
                    let marker = new L.Marker(latLng, {title: photo.name});
                    marker.gallery = photoGallery;
                    /*this.markersCluster.gallery = photoGallery;*/
                    this.markersCluster.addLayer(marker);
                }//--end if--
            }//-- end for --
            this.list = new L.Control.ListMarkers({layer: this.markersCluster, itemIcon: null, maxZoom: this.maxZoom});
            this.myMap.addControl(this.list);

            this.list.on('item-click', e => {

                /*console.log(this.list);*/
                let imageGallery = new Gallery(e.layer.gallery);

                $("#rslides").removeClass();
                $('.rslides_nav').remove();
                $("#rslides").responsiveSlides({
                    auto: true,
                    speed: 400,
                    timeout: 3000,
                    pause: true,
                    pagination: false,
                    nav: true,
                    maxwidth: 800
                });

                $('.li').magnificPopup({
                    delegate: "a",
                    type: 'image',
                    closeOnContentClick : true,
                    closeBtnInside : false,
                    fixedContentPos : true,
                    mainClass: 'mfp-no-margins mfp-with-zoom',
                    image: {
                        verticalFit: true
                    },
                    zoom: {
                        enabled: true,
                        duration: 500
                    }

                });

                $('#boundsGallery').multislider({interval: 3000});
                $('#boundsGallery').magnificPopup({
                    delegate: "a",
                    type: 'image',
                    closeOnContentClick : true,
                    closeBtnInside : false,
                    fixedContentPos : true,
                    mainClass: 'mfp-no-margins mfp-with-zoom',
                    image: {
                        verticalFit: true
                    },
                    zoom: {
                        enabled: true,
                        duration: 500
                    }

                });
            })//-- end list.on --
            this.myMap.on('moveend', (e) => {

                $("#boundsGallery").removeClass();
                //on récupère les limites de la carte
                let bounds =this.myMap.getBounds();
                let latMin = bounds.getSouthWest().lat;
                let lngMin = bounds.getSouthWest().lng;
                let latMax = bounds.getNorthEast().lat;
                let lngMax = bounds.getNorthEast().lng

                let controleur = new ControllerAjax(latMin, latMax, lngMin, lngMax);
                const text = document.getElementById("text");
                $('h3').remove();
                $('.empty').remove();

                const title = document.createElement("h3");
                title.appendChild(document.createTextNode("Dans le même secteur :"));
                text.appendChild(title);
                const empty = document.createElement("p");
                empty.className = "empty";
                empty.appendChild(document.createTextNode("Aucune suggestion dans cette zone !"));
                text.appendChild(empty);

                if(document.getElementsByClassName("thumbnailsLink") !== null){
                    if(document.getElementById("thumbnailsLink").href === document.getElementById("thumbnailsLink2").href ){
                        document.getElementById("thumbnailsLink2").parentNode.remove();
                    }
                }
            })//-- end myMyap.moveend --
        });//-- end ajaxGet --
    }//-- end photoRecorvery --

    contains(needle){
        // Per spec, the way to identify NaN is that it is not equal to itself
        let findNaN = needle !== needle;
        let indexOf;
        if(!findNaN && typeof Array.prototype.indexOf === 'function') {
            indexOf = Array.prototype.indexOf;
        } else {
            indexOf = needle =>{
                let i = -1, index = -1;
                for(i = 0; i < this.length; i++) {
                    let item = this[i];
                    if((findNaN && item !== item) || item === needle) {
                        index = i;
                        break;
                    }
                }
                return index;
            };
        }
        return indexOf.call(this, needle) > -1;
    }

}//---- END CLASS LEAFLETMAP ----