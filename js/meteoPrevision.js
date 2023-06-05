class MeteoPrevision {
    API_KEY = '1bb4c8d6af655f2773fff0b23de4e94e';
    unidades = '&units=metric';
    idioma = '&lang=es';
    tipo = '&mode=xml'
    error = '<p>¡problemas! No puedo obtener información de <a href=\'http://openweathermap.org\'>OpenWeatherMap</a></p>';

    cargarDatos(lat, lon) {
        this.url = 'https://api.openweathermap.org/data/2.5/forecast?lat=' + lat + '&lon=' + lon + '&cnt=7&appid=' + this.API_KEY;

        $.ajax({
            dataType: 'json',
            url: this.url,
            method: 'GET',
            context: this,
            success: function (data) {
                this.datos = data;
                this.verDatos();
            },
            error: function () {
                $("body").append(this.error);
            }
        });
    }

    verDatos = function () {
        $('#meteoData').empty();

        let list = this.datos.list;

        let date = new Date();
        list.forEach(dayForecast => {
            $('#meteoData').append('<h3>' + date.toLocaleDateString('es-ES') + '</h3>');

            $('#meteoData').append('<img src="http://openweathermap.org/img/wn/' + dayForecast.weather[0].icon +
                '.png" alt="Icono de las condiciones de la previsión">');

            date.setDate(date.getDate() + 1)
        });
    }
}

let meteo = new MeteoPrevision();

meteo.cargarDatos(43.515764, -6.751075)