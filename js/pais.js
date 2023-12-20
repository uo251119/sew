class Pais {
    constructor(nombre, capital, poblacion) {
        this.nombre = nombre;
        this.capital = capital;
        this.poblacion = poblacion;
    }

    otrosDatos(gobierno, coordenadas, religion) {
        this.setGobierno(gobierno);
        this.setCoordenadas(coordenadas);
        this.setReligion(religion);
    }

    getOtrosDatosHTML() {
        return "<ul>"
            + "<li>" + this.poblacion + "</li>"
            + "<li>" + this.gobierno + "</li>"
            + "<li>" + this.religion + "</li>"
            + "</ul>";
    }

    setNombre(nombre) {
        this.nombre = nombre;
    }

    getNombre() {
        return this.nombre;
    }

    setCapital(capital) {
        this.capital = capital;
    }

    getCapital() {
        return this.capital;
    }

    setPoblacion(poblacion) {
        this.poblacion = poblacion;
    }

    setGobierno(gobierno) {
        this.gobierno = gobierno;
    }

    setCoordenadas(coordenadas) {
        this.coordenadas = coordenadas;
    }

    setReligion(religion) {
        this.religion = religion;
    }

    writeCoordiatesIntoHTMLDocument() {
        document.write("(" + this.coordenadas.latitud + ", " + this.coordenadas.longitud + ")");
    }

    cargarMeteoDatos() {
        let API_KEY_OPENWEATHERMAPS = '1bb4c8d6af655f2773fff0b23de4e94e';

        $.ajax({
            dataType: 'json',
            url: 'https://api.openweathermap.org/data/2.5/forecast?units=metric&lang=es&q=' + this.capital + '&cnt=5&appid=' + API_KEY_OPENWEATHERMAPS,
            method: 'GET',
            context: this,
            success: function (data) {
                this.meteoDatos = data;
                this.verMeteoDatos();
            },
            error: function () {
                $("body").append('<p>¡problemas! No puedo obtener información de <a href="http://openweathermap.org">OpenWeatherMap</a></p>');
            }
        });
    }

    verMeteoDatos = function () {
        $('#meteoData').empty();

        let list = this.meteoDatos.list;

        let date = new Date();
        list.forEach(dayForecast => {
            $('body section').append('<h4>' + date.toLocaleDateString('es-ES') + '</h4>');

            $('body section').append('<img src="http://openweathermap.org/img/wn/' + dayForecast.weather[0].icon +
                '.png" alt="Icono de las condiciones de la previsión">');

            $('body section').append('<p>Temperatura máxima: ' + dayForecast.main.temp_max);
            $('body section').append('<p>Temperatura mínima: ' + dayForecast.main.temp_min);
            $('body section').append('<p>Humedad: ' + dayForecast.main.humidity + '%');

            console.log(dayForecast.main);

            date.setDate(date.getDate() + 1)
        });
    }

}