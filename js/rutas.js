class Rutas {
    rutasDocument;

    constructor() {
        this.rutasDocument = this.readText("xml/rutas.xml");
        this.inicializarRutas();
    }

    readText(rutaLocal) {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", rutaLocal, false);
        xmlhttp.send();

        let texto = null;
        if (xmlhttp.status == 200) {
            texto = xmlhttp.responseText;
        }

        let parser = new DOMParser();
        let xmlDoc = parser.parseFromString(texto, "text/xml");

        return xmlDoc;
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
                "<h2>" + nombre + "</h2>" +
                "<button onclick='rutas.generarKML(" + rutaIndex + ")'>Descargar KML</button>" +
                "<button onclick='rutas.generarSVG(" + rutaIndex + ")'>Descargar SVG</button>" +
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
                    rutaHtmlString += "<img src='multimedia/" + foto.textContent + "' alt='Imagen del hito'></img>";
                });


                if (videos != null) {
                    videos = videos.querySelectorAll("video");

                    videos.forEach(video => {
                        rutaHtmlString += "<video width='400' height='300' controls> <source src='multimedia/" +
                            video.textContent + "' type='video/mp4'> </video>";
                    });
                }
                rutaHtmlString += "</section>"
            });

            rutaHtmlString += "</section>"

            $("#rutas").append(rutaHtmlString);

            rutaIndex++;
        });

    }

    generarKML(rutaIndex) {
        let kmlString;

        let ruta = this.rutasDocument.querySelectorAll("ruta")[rutaIndex];
        let nombre = ruta.querySelector("nombre").textContent;

        let hitos = ruta.querySelector("hitos").querySelectorAll("hito");

        kmlString = '<?xml version="1.0" encoding="UTF-8"?> \n' +
            '<kml xmlns="http://www.opengis.net/kml/2.2"> \n' +
            '\t<Document>\n' +
            '\t\t<name>' + 'Rutas' + '</name> \n' +
            '\t\t<Style id="red-line"> \n' +
            '\t\t\t<LineStyle> \n' +
            '\t\t\t\t<width>2</width> \n' +
            '\t\t\t\t<color>ff0000ff</color> \n' +
            '\t\t\t</LineStyle> \n' +
            '\t\t</Style> \n' +
            '\t\t<Placemark> \n' +
            '\t\t\t<name>' + nombre + '</name>\n' +
            '\t\t\t<styleUrl>#red-line</styleUrl>\n' +
            '\t\t\t<LineString>\n' +
            '\t\t\t\t<tessellate>1</tessellate>\n' +
            '\t\t\t\t<coordinates>\n'

        hitos.forEach(hito => {
            let latitud = hito.querySelector("latitud").textContent;
            let longitud = hito.querySelector("longitud").textContent;

            kmlString += '\t\t\t\t\t' + longitud + ',' + latitud + ',0.0\n';
        });

        kmlString +=
            '\t\t\t\t</coordinates>\n' +
            '\t\t\t</LineString>\n' +
            '\t\t</Placemark>\n' +
            '\t</Document> \n' +
            '</kml>';


        let element = document.createElement("a");
        element.setAttribute("href", "data:text/xml;charset=utf-8," + encodeURIComponent(kmlString));

        let filename = nombre.trim().replaceAll(" ", "_") + ".kml";
        element.setAttribute("download", filename);

        element.style.display = "none";
        document.body.appendChild(element);

        element.click();

        document.body.removeChild(element);
    }

    generarSVG(rutaIndex) {
        let svgString;

        let ruta = this.rutasDocument.querySelectorAll("ruta")[rutaIndex];
        let nombre = ruta.querySelector("nombre").textContent;

        let hitos = ruta.querySelector("hitos").querySelectorAll("hito");

        let altitudes = ruta.querySelectorAll("altitud");
        let maxAltitud = parseInt(altitudes[0].textContent);
        let minAltitud = parseInt(altitudes[0].textContent);

        altitudes.forEach(altitudString => {
            let altitud = parseInt(altitudString.textContent)

            if (altitud > maxAltitud) {
                maxAltitud = altitud;
            }
            if (altitud < minAltitud) {
                minAltitud = altitud;
            }

        });

        svgString =
            '<svg viewBox="0 0 600 609" class="chart"> \n' +
            '\t<text x="5" y="20">' + maxAltitud + 'm</text>\n' +
            '\t<text x="5" y="220">' + minAltitud + 'm</text>\n' +
            '\t<polyline fill="none" stroke="#ff0000" stroke-width="1"\n' +
            '\t\tpoints="\n';

        let x = 100;
        hitos.forEach(hito => {
            let altitud = hito.querySelector("altitud").textContent;
            let y = ((1 - ((parseInt(altitud) - minAltitud) / (maxAltitud - minAltitud))) * 200) + 20;

            svgString += '\t\t\t' + x + ',' + y + '\n';

            x += 20;
        });

        svgString +=
            '\t\t\t"/>\n' +
            '</svg>';

        let element = document.createElement('a');
        element.setAttribute('href', 'data:text/xml;charset=utf-8,' + encodeURIComponent(svgString));

        let filename = nombre.trim().replaceAll(" ", "_") + ".svg";
        element.setAttribute('download', filename);

        element.style.display = 'none';
        document.body.appendChild(element);

        element.click();

        document.body.removeChild(element);
    }
}

let rutas = new Rutas();