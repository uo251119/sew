import xml.etree.ElementTree as ET

ns = {'': 'http://uo251119/rutas'}

tree = ET.parse('rutasEsquema.xml')
rutas = tree.getroot()

i = 1

prevAltitud = -1
x = 50

for ruta in rutas.findall('ruta', ns):
    filename = "perfil" + str(i) + ".svg"
    file = open(filename, "a")

    file.write('<svg viewBox="0 0 400 400" class="chart">\n')
    file.write('<style>\n')
    file.write('\t.text {font: bold 8px serif; }\n')
    file.write('</style>\n')

    hitos = ruta.find('hitos', ns)
    for hito in hitos:
        coordenadas = hito.find('coordenadas', ns)
        altitud = coordenadas.find('altitud', ns).text
        if prevAltitud != -1:
            file.write('<line x1="' + str(x) + '" y1="' + str(300-((int(prevAltitud)/8000)*300)) + '" x2="' + str(x+10) + '" y2="' + str(300-((int(altitud)/8000)*300)) + '" stroke="red" />\n')
            x += 10

        prevAltitud = altitud

    file.write('</svg>\n')
    i += 1