class Gallery {

    constructor(source) {
        this.source = source;
        this.createGallery(this.source);
    }//-- end constructor --

    createGallery(source){
        const gallery = document.getElementById("rslides");
        if(document.getElementsByClassName("thumbnailsLink")){
            gallery.innerHTML="";
        }
        source.forEach(element => {
            const li = document.createElement("li")
            li.className = `li`;
            li.name = `photo_${element.id}`

            const link = document.createElement("a");
            link.className = "thumbnailsLink";
            link.href = `http://localhost/OpenDeclic/P9/${element.url}`;

            const thumbnails = document.createElement("img");
            thumbnails.className = "thumbnails";
            thumbnails.alt = element.description;
            thumbnails.src =  element.url;

            link.appendChild(thumbnails);
            li.appendChild(link);

            const caption = document.createElement("p");
            caption.className = "caption";
            caption.appendChild(document.createTextNode(element.description));
            li.appendChild(caption);
            gallery.appendChild(li);
        });
    }//-- end createGallery --
}//---- END CLASS GALLERY ----