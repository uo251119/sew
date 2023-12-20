class Fondo {

    FLICKR_PHOTO_SEARCH_BASE_URL = "https://www.flickr.com/services/rest/?method=flickr.photos.search";

    FLICKR_API_KEY = "caa2f6c1ad344b58bfd3e76a81178454";
    FLICKR_SECRET = "21e6e97e87d89589";

    constructor(pais, capital, coordenadasCapital) {
        this.pais = pais;
        this.capital = capital;
        this.coordenadasCapital = coordenadasCapital;
    }

    obtenerFondo() {
        let url = this.FLICKR_PHOTO_SEARCH_BASE_URL
            + "&api_key=" + this.FLICKR_API_KEY
            + "&text=" + this.pais.replace(" ", "+")
            + "&format=json&nojsoncallback=1";

        console.log(url);
        $.ajax({
            dataType: 'json',
            url: url,
            method: 'GET',
            context: this,
            success: function (data) {
                console.log(data);

                let photoIndex = 0;
                if (data.photos.photo.length == 0) {
                    console.alert("No photo was found for search: " + this.pais.replace(" ", "+"));
                    return;
                } else {
                    photoIndex = Math.floor(Math.random() * data.photos.photo.length);
                }

                let photo = data.photos.photo[photoIndex];

                let imageUrl = "https://live.staticflickr.com"
                    + "/" + photo.server
                    + "/" + photo.id
                    + "_" + photo.secret
                    + ".jpg";

                document.getElementsByTagName("html")[0].style.backgroundImage = 'url("' + imageUrl + '"';
            },
            error: function () {
                $("body").append(this.error);
            }
        });
    }
}