class GeoLocalizacion {

    cargarDatos() {
        let longitude = '-6.751075';
        let latitude = '43.515764';

        let baseUrl = 'https://api.mapbox.com/styles/v1/mapbox/streets-v12/static/';
        let marker = 'geojson(%7B%22type%22%3A%22Point%22%2C%22coordinates%22%3A%5B' + longitude + '%2C' + latitude + '%5D%7D)/';
        let token = 'pk.eyJ1IjoiamFpbWVmbSIsImEiOiJjbGI5ODE1bnkwcWtkM29yc2cyOWdldjM2In0.YNKqb1opv6SKwyzsD5v1zg';
        let src = baseUrl + marker + longitude + ',' + latitude + ',8,0,20/400x300?access_token=' + token;

        $('#mapaCoaña').append('<img src="' + src + '" alt="mapa estático">');
    }
}

let geoLocalizacion = new GeoLocalizacion();
geoLocalizacion.cargarDatos();