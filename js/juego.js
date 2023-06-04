class Juego {
    preguntasAleatorias = true;
    juegoTerminado = true;
    reiniciarPuntos = true;

    suspenderBotones = false;

    preguntas;

    constructor() {
        var basePreguntas = this.readText("js/base-preguntas.json");
        this.preguntas = JSON.parse(basePreguntas);
        this.escogerPreguntaAleatoria();
    };

    readText(rutaLocal) {
        var texto = null;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", rutaLocal, false);
        xmlhttp.send();
        if (xmlhttp.status == 200) {
            texto = xmlhttp.responseText;
        }
        return texto;
    }

    pregunta;
    posibles_respuestas;

    selectId(id) {
        return document.getElementById(id);
    }
    btn_correspondiente = [
        this.selectId("btn1"),
        this.selectId("btn2"),
        this.selectId("btn3"),
        this.selectId("btn4"),
        this.selectId("btn5")
    ];
    numeroPreguntas = [];

    preguntasCompletadas = 0;
    preguntasCorrectas = 0;

    escogerPreguntaAleatoria() {
        let n;
        if (this.preguntasAleatorias) {
            n = Math.floor(Math.random() * this.preguntas.length);
        } else {
            n = 0;
        }

        while (this.numeroPreguntas.includes(n)) {
            n++;
            if (n >= this.preguntas.length) {
                n = 0;
            }
            if (this.numeroPreguntas.length == this.preguntas.length) {

                if (this.juegoTerminado) {
                    this.selectId("seccionJuego").innerHTML =
                        '<p>Juego terminado. Puntuación: '
                        + this.preguntasCorrectas + '/' + this.preguntasCompletadas
                        + '</p>';
                }

                if (this.reiniciarPuntos) {
                    this.preguntasCorrectas = 0
                    this.preguntasCompletadas = 0
                }
                this.numeroPreguntas = [];
            }
        }
        this.numeroPreguntas.push(n);
        this.preguntasCompletadas++;

        this.escogerPregunta(n);
    }

    escogerPregunta(n) {
        this.pregunta = this.preguntas[n];
        this.selectId("pregunta").innerHTML = "";

        if (this.pregunta.categoria) {
            this.selectId("categoria").innerHTML = this.pregunta.categoria;
        }
        if (this.pregunta.pregunta) {
            this.selectId("pregunta").innerHTML = this.pregunta.pregunta;
        }

        if (this.preguntasCompletadas > 1) {
            this.selectId("puntuacion").innerHTML = 'Puntuación: ' + this.preguntasCorrectas + '/' + (this.preguntasCompletadas - 1);
        } else {
            this.selectId("puntuacion").innerHTML = 'Puntuación: 0/0';
        }

        this.style("imagen").objectFit = this.pregunta.objectFit;

        this.desordenarRespuestas(this.pregunta);

        if (this.pregunta.imagen) {
            this.selectId("imagen").setAttribute("src", this.pregunta.imagen);
            this.style("imagen").width = "60%";
            this.style("imagen").height = "auto";
            this.style("imagen").maxHeight = "300px";
            this.style("imagen").objectFit = "contain";
            this.style("imagen").visibility = "visible";
        } else {
            this.style("imagen").height = "0";
            this.style("imagen").visibility = "hidden";
        }
    }

    desordenarRespuestas(pregunta) {
        this.posibles_respuestas = [
            pregunta.respuesta,
            pregunta.incorrecta1,
            pregunta.incorrecta2,
            pregunta.incorrecta3,
            pregunta.incorrecta4,
        ];
        this.posibles_respuestas.sort(() => Math.random() - 0.5);

        this.selectId("btn1").innerHTML = this.posibles_respuestas[0];
        this.selectId("btn2").innerHTML = this.posibles_respuestas[1];
        this.selectId("btn3").innerHTML = this.posibles_respuestas[2];
        this.selectId("btn4").innerHTML = this.posibles_respuestas[3];
        this.selectId("btn5").innerHTML = this.posibles_respuestas[4];
    }

    elegirRespuesta(i) {
        if (this.suspenderBotones) {
            return;
        }
        this.suspender_botones = true;
        if (this.posibles_respuestas[i] == this.pregunta.respuesta) {
            this.preguntasCorrectas++;
            this.btn_correspondiente[i].style.background = "lightgreen";
        } else {
            this.btn_correspondiente[i].style.background = "pink";
        }
        for (let j = 0; j < 4; j++) {
            if (this.posibles_respuestas[j] == this.pregunta.respuesta) {
                this.btn_correspondiente[j].style.background = "lightgreen";
                break;
            }
        }

        setTimeout(() => {
            this.reiniciar();
            this.suspender_botones = false;
        }, 1000);
    }

    reiniciar() {
        for (const btn of this.btn_correspondiente) {
            btn.style.background = "white";
        }
        this.escogerPreguntaAleatoria();
    }

    style(id) {
        return this.selectId(id).style;
    }
}
const juego = new Juego();