import xml.etree.ElementTree as ET

ns = {'': 'http://uo251119/rutas'}

tree = ET.parse('rutasEsquema.xml')
rutas = tree.getroot()

i = 1

for ruta in rutas.findall('ruta', ns):
    filename = "ruta" + str(i) + ".kml"
    file = open(filename, "a")

    nombre = ruta.find('nombre', ns).text
    descripcion = ruta.find('descripcion', ns).text

    file.write('<?xml version="1.0" encoding="UTF-8"?>\n')
    file.write('<kml xmlns="http://www.opengis.net/kml/2.2">\n')
    file.write('\t<Document>\n')
    file.write('\t\t<name>Rutas</name>\n')
    file.write('\t\t<Style id="redLine"><LineStyle><color>ff0000ff</color><width>10</width></LineStyle></Style>\n')
    file.write('\t\t<Placemark>\n');
    file.write('\t\t\t<styleUrl>#redLine</styleUrl>\n');
    file.write('\t\t\t<name>' + nombre + '</name>\n');
    file.write('\t\t\t<description>\n\t\t\t' + descripcion + '\n\t\t\t</description>\n');

    file.write('\t\t\t<LineString>\n')
    file.write('\t\t\t\t<extrude>1</extrude>\n')
    file.write('\t\t\t\t<tessellate>2</tessellate>\n')
    file.write('\t\t\t\t<altitudeMode>clampToGround</altitudeMode>\n')
    file.write('\t\t\t\t<coordinates>\n')

    hitos = ruta.find('hitos', ns)
    for hito in hitos:
        coordenadas = hito.find('coordenadas', ns)
        latitud = coordenadas.find('latitud', ns).text
        longitud = coordenadas.find('longitud', ns).text
        altitud = coordenadas.find('altitud', ns).text
        file.write('\t\t\t\t\t' + longitud + ',' + latitud + ','+ altitud + '\n')

        prevAltitud = altitud

    file.write('\t\t\t\t</coordinates>\n')
    file.write('\t\t\t</LineString>\n')
    file.write('\t\t</Placemark>\n')
    file.write('\t</Document>\n')
    file.write('</kml>\n')

    i += 1