class Meteo {
    apikey = '1bb4c8d6af655f2773fff0b23de4e94e';
    unidades = '&units=metric';
    idioma = '&lang=es';
    error = '<p>¡problemas! No puedo obtener información de <a href=\'http://openweathermap.org\'>OpenWeatherMap</a></p>';

    cargarDatos(ciudad) {
        this.ciudad = ciudad;
        this.url = 'https://api.openweathermap.org/data/2.5/weather?q=' + this.ciudad + this.unidades + this.idioma + '&APPID=' + this.apikey;
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

        $('#meteoData').append('<h2>Datos ' + this.ciudad + '</h2>');
        $('#meteoData').append('<img src="http://openweathermap.org/img/wn/' + this.datos.weather[0].icon +
            '.png" alt="Icono de las condiciones actuales (' + this.datos.weather[0].icon + ')">');
        $('#meteoData').append('<p>Ciudad: ' + this.datos.name + '</p>');
        $('#meteoData').append('<p>País: ' + this.datos.sys.country + '</p>');
        $('#meteoData').append('<p>Latitud: ' + this.datos.coord.lat + ' grados</p>');
        $('#meteoData').append('<p>Longitud: ' + this.datos.coord.lon + ' grados</p>');
        $('#meteoData').append('<p>Temperatura: ' + this.datos.main.temp + ' grados Celsius</p>');
        $('#meteoData').append('<p>Temperatura máxima: ' + this.datos.main.temp_max + ' grados Celsius</p>');
        $('#meteoData').append('<p>Temperatura mínima: ' + this.datos.main.temp_min + ' grados Celsius</p>');
        $('#meteoData').append('<p>Presión: ' + this.datos.main.pressure + ' milímetros</p>');
        $('#meteoData').append('<p>Humedad: ' + this.datos.main.humidity + '%</p>');
        $('#meteoData').append('<p>Amanece a las: ' + new Date(this.datos.sys.sunrise * 1000).toLocaleTimeString() + '</p>');
        $('#meteoData').append('<p>Oscurece a las: ' + new Date(this.datos.sys.sunset * 1000).toLocaleTimeString() + '</p>');
        $('#meteoData').append('<p>Dirección del viento: ' + this.datos.wind.deg + '  grados</p>');
        $('#meteoData').append('<p>Velocidad del viento: ' + this.datos.wind.speed + ' metros/segundo</p>');
        $('#meteoData').append('<p>Hora de la medida: ' + new Date(this.datos.dt * 1000).toLocaleTimeString() + '</p>');
        $('#meteoData').append('<p>Fecha de la medida: ' + new Date(this.datos.dt * 1000).toLocaleDateString() + '</p>');
        $('#meteoData').append('<p>Descripción: ' + this.datos.weather[0].description + '</p>');
        $('#meteoData').append('<p>Visibilidad: ' + this.datos.visibility + ' metros</p>');
        $('#meteoData').append('<p>Nubosidad: ' + this.datos.clouds.all + ' %</p>');
    }
}

let meteo = new Meteo();
meteo.cargarDatos("Coaña");