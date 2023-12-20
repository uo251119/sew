class Viajes {

    MAPBOX_API_TOKEN = 'pk.eyJ1IjoiamFpbWVmbSIsImEiOiJjbGI5ODE1bnkwcWtkM29yc2cyOWdldjM2In0.YNKqb1opv6SKwyzsD5v1zg';

    longitude;
    latitude;
    altitude;

    mapaDinamicoGoogle = new Object();

    carruselIndex = 0;
    carruselMaxIndex = 9;

    constructor() {
        this.mapaDinamicoGoogle.initMap = this.mapaDinamico;
        navigator.geolocation.getCurrentPosition(this.guardarCoordenadas.bind(this), this.handleError.bind(this));

        this.hideAllImages();
        this.showImage(this.carruselIndex);
    }

    guardarCoordenadas(position) {
        this.longitude = position.coords.longitude;
        this.latitude = position.coords.latitude;
        this.altitude = position.coords.altitude;
    }

    handleError(error) {
        let errorMessage = 'Error desconocido';

        switch (error.code) {
            case error.PERMISSION_DENIED:
                errorMessage = 'El usuario no permite la petición de geolocalización'
                break;
            case error.POSITION_UNAVAILABLE:
                errorMessage = 'Información de geolocalización no disponible'
                break;
            case error.TIMEOUT:
                errorMessage = 'La petición de geolocalización ha caducado'
                break;
        }

        alert(errorMessage);
    }

    mapaEstatico() {
        let baseUrl = 'https://api.mapbox.com/styles/v1/mapbox/streets-v12/static/';
        let marker = 'geojson(%7B%22type%22%3A%22Point%22%2C%22coordinates%22%3A%5B' + this.longitude + '%2C' + this.latitude + '%5D%7D)/';
        let src = baseUrl + marker + this.longitude + ',' + this.latitude + ',15.25,0,60/400x400?access_token=' + this.MAPBOX_API_TOKEN;

        $('body main').append('<h2>Mapa estático</h2>');
        $('body main').append('<img src="' + src + '" alt="Mapa estático">');
    }

    mapaDinamico() {
        navigator.geolocation.getCurrentPosition(this.cargarDatosMapaDinamico.bind(this), this.mostrarError.bind(this));
    }

    cargarDatosMapaDinamico() {
        let mapaElement = document.getElementsByTagName('main')[0].getElementsByTagName('section')[0].getElementsByTagName('section')[0];

        let position = { lat: this.latitude, lng: this.longitude };
        let mapa = new google.maps.Map(mapaElement, { zoom: 8, center: position });
        this.marcadorMapaDinamico = new google.maps.Marker({ position: position, map: mapa });
    }

    loadRutasFile(input) {
        let file = input[0];

        let reader = new FileReader();
        reader.onload = (event) => {
            let fileText = reader.result;

            let parser = new DOMParser();
            this.rutasDocument = parser.parseFromString(fileText, 'application/xml');
            this.inicializarRutas();
        }

        reader.readAsText(file);
    }

    inicializarRutas() {
        let rutaHtmlString;

        let rutas = this.rutasDocument.querySelectorAll("ruta");

        let rutaIndex = 0;

        rutas.forEach(ruta => {
            let nombre = ruta.querySelector("nombre").textContent;
            let tipo = ruta.querySelector("tipo").textContent;
            let medioTransporte = ruta.querySelector("medioTransporte").textContent;
            let fechaInicio = ruta.querySelector("fechaInicio").textContent;
            let horaInicio = ruta.querySelector("horaInicio").textContent;
            let duracion = ruta.querySelector("duracion").textContent;
            let agencia = ruta.querySelector("agencia").textContent;
            let descripcion = ruta.querySelector("descripcion").textContent;
            let personasAdecuadas = ruta.querySelector("personasAdecuadas").textContent;
            let lugarInicio = ruta.querySelector("lugarInicio").textContent;
            let direccionInicio = ruta.querySelector("direccionInicio").textContent;
            let coordenadas = ruta.querySelector("coordenadas");
            let latitud = coordenadas.querySelector("latitud").textContent;
            let longitud = coordenadas.querySelector("longitud").textContent;
            let altitud = coordenadas.querySelector("altitud").textContent;
            let recomendacion = ruta.querySelector("recomendacion").textContent;
            let referencias = ruta.querySelector("referencias").querySelectorAll("referencia");
            let hitos = ruta.querySelector("hitos").querySelectorAll("hito");

            rutaHtmlString = "";

            rutaHtmlString +=
                "<section>" +
                "<h3>" + nombre + "</h3>" +
                "<p>" + descripcion + "</p>";

            rutaHtmlString +=
                "<ul>" +
                "<li>Tipo de ruta: " + tipo + "</li>" +
                "<li>Medio de transporte: " + medioTransporte + "</li>" +
                "<li>Fecha de inicio: " + fechaInicio + "</li>" +
                "<li>Hora de inicio: " + horaInicio + "</li>" +
                "<li>Duración: " + duracion + "</li>" +
                "<li>Agencia: " + agencia + "</li>" +
                "<li>Personas adecuadas: " + personasAdecuadas + "</li>" +
                "<li>Lugar de inicio: " + lugarInicio + "</li>" +
                "<li>Dirección: " + direccionInicio + "</li>" +
                "<li>Latitud: " + latitud + "</li>" +
                "<li>Longitud: " + longitud + "</li>" +
                "<li>Altitud: " + altitud + "m" + "</li>" +
                "<li>Recomendación: " + recomendacion + "</li>" +
                "<li>Referencias:<ul>";

            referencias.forEach(referencia => {
                rutaHtmlString +=
                    "<li><a href=" + referencia.textContent + ">" + referencia.textContent + "</a></li>";
            });

            rutaHtmlString += "</ul></li></ul><h3>Hitos</h3>"

            hitos.forEach(hito => {
                let nombre = hito.querySelector("nombre").textContent;
                let distanciaAnterior = hito.querySelector("distanciaHitoAnterior").textContent + hito.querySelector("distanciaHitoAnterior").getAttribute("unidades");
                let descripcion = hito.querySelector("descripcion").textContent;
                let fotografias = hito.querySelector("fotografias").querySelectorAll("fotografia");
                let videos = hito.querySelector("videos");

                rutaHtmlString += "<section>" +
                    "<h4>" + nombre + " - " + distanciaAnterior + "</h4>" +
                    "<p>" + descripcion + "</p>";

                fotografias.forEach(foto => {
                    rutaHtmlString += "<img src='multimedia/imagenes/" + foto.textContent + "' alt='Imagen del hito'></img>";
                });


                if (videos != null) {
                    videos = videos.querySelectorAll("video");

                    videos.forEach(video => {
                        rutaHtmlString += "<video width='400' height='300' controls> <source src='multimedia/videos/" +
                            video.textContent + "' type='video/mp4'> </video>";
                    });
                }
                rutaHtmlString += "</section>"
            });

            rutaHtmlString += "</section>"

            $('#rutas').append(rutaHtmlString);

            rutaIndex++;
        });
    }

    loadAltimetriaFiles(files) {
        Array.from(files).forEach((file) => {
            let reader = new FileReader();
            reader.onload = (event) => {
                let fileText = reader.result;

                let parser = new DOMParser();
                //let altimetriaDocument = parser.parseFromString(fileText, 'image/svg+xml');
                $('#altimetrias').append(fileText);
            }

            reader.readAsText(file);
        });
    }

    hideAllImages() {
        $('img').css('display', 'none');
    }

    showImage(index) {
        $('img:eq(' + index + ')').css('display', 'block');
    }

    carruselNext() {
        this.carruselIndex += 1;
        if (this.carruselIndex > this.carruselMaxIndex) {
            this.carruselIndex = 0;
        }

        this.hideAllImages();
        this.showImage(this.carruselIndex);

    }
    carruselPrev() {
        this.carruselIndex -= 1;
        if (this.carruselIndex < 0) {
            this.carruselIndex = this.carruselMaxIndex;
        }

        this.hideAllImages();
        this.showImage(this.carruselIndex);
    }
}
