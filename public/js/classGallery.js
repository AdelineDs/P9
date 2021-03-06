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
            const li = document.createElement("li");
            li.className = `li`;
            li.name = `photo_${element.id}`;

            const link = document.createElement("a");
            link.className = "thumbnailsLink";
            link.href = `http://projet9.adeline-decarpentries.fr/${element.url}`;

            const thumbnails = document.createElement("img");
            thumbnails.className = "thumbnails";
            thumbnails.alt = element.description;
            thumbnails.src =  element.url;

            link.appendChild(thumbnails);
            li.appendChild(link);

            const caption = document.createElement("p");
            caption.className = "caption";
            caption.appendChild(document.createTextNode(`${element.name} - `));

            const likes = document.createElement("p");
            likes.className = "likes";
            const heart = document.createElement("i");
            heart.className = "fas fa-heart";

            caption.appendChild(heart);
            caption.appendChild(document.createTextNode(` ${element.likes}`));

            const linkAuthor = document.createElement("a");
            linkAuthor.href = `?action=member&id=${element.idMember}`;

            const author = document.createElement("p");
            author.className = "author";
            author.appendChild(document.createTextNode(element.pseudo));

            linkAuthor.appendChild(author);

            li.appendChild(caption);
            li.appendChild(linkAuthor);
            gallery.appendChild(li);
        });
    }//-- end createGallery --
}//---- END CLASS GALLERY ----