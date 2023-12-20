class Agenda {
    last_api_call = null;
    last_api_result = null;

    constructor(url) {
        this.url = url;

        Array.from($('button')).forEach(button => {
            button.setAttribute('onclick', 'agenda.consultarTemporadaActual()');
        });
    }

    consultarTemporadaActual() {
        if (this.last_api_call != null) {
            let date = new Date();
            console.log(this.last_api_call);
            console.log(date.getTime() - 10 * 60000);
            let intervalPassed = (date.getTime() - 10 * 60000) < this.last_api_call;
            if (intervalPassed) {
                return;
            }
        }

        $.ajax({
            dataType: 'xml',
            url: this.url,
            method: 'GET',
            context: this,
            success: function (data) {
                this.last_api_result = data;
                this.last_api_call = new Date().getTime();
                this.mrData = data;
                this.verMrData();
            },
            error: function () {
                $("body").append('<p>¡problemas! No puedo obtener información de <a href="http://ergast.com/api/f1/current">Ergast Developer API</a></p>');
            }
        });
    }

    verMrData = function () {
        let list = this.mrData.getElementsByTagName('Race');

        $('body section').append('<h2>Carreras de esta temporada:</h2>');

        Array.from(list).forEach(race => {
            $('body section').append('<h3>' + race.getElementsByTagName('RaceName')[0].textContent + '</h3>');

            let circuit = race.getElementsByTagName('Circuit')[0];

            $('body section').append('<p>Circuito: ' + circuit.getElementsByTagName('CircuitName')[0].textContent + '</p>');
            $('body section').append('<p>Fecha: ' + race.getElementsByTagName('Date')[0].textContent + '</p>');
            $('body section').append('<p>Hora: ' + race.getElementsByTagName('Time')[0].textContent + '</p>');
            $('body section').append('<p>Coordenadas: (' + circuit.getElementsByTagName('Location')[0].getAttribute('lat') + ',' + circuit.getElementsByTagName('Location')[0].getAttribute('long') + ')</p>');
        });
    }
}