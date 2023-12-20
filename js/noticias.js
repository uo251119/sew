class Noticias {

    noticiasCargadas = false;

    constructor() {
        if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
            alert('Este navegador no soporta el API File.')
        }

        Array.from($('button')).forEach(button => {
            button.setAttribute('onclick', 'noticias.introducirNuevaNoticiaPorCampos()');
        });
    }

    readInputFile(input) {
        let file = input[0];

        let reader = new FileReader();
        reader.onload = (event) => {
            let lines = reader.result.split('\n');

            lines.forEach(line => {
                let noticia = line.split('_');

                let titular = noticia[0];
                let entradilla = noticia[1];
                let texto = noticia[2];
                let autor = noticia[3];

                this.nuevaNoticia(titular, entradilla, autor, texto);
            });
        }

        reader.readAsText(file);
    }

    introducirNuevaNoticiaPorCampos() {
        let title = $("#title").val();
        let entrance = $("#entrance").val();
        let author = $("#author").val();
        let text = $("#text").val();

        console.log(title, entrance, author, text);
        if (title && entrance && author && text) {
            this.nuevaNoticia(title, entrance, author, text);
        } else {
            alert('Algún campo está vacío. Rellene todos los campos para crear una nueva noticia.')
        }
    }

    nuevaNoticia(titular, entradilla, autor, texto) {
        if (!this.noticiasCargadas) {
            $('body main section:nth-child(3) p').remove();
            this.noticiasCargadas = true;
        }

        $('body main section:nth-child(3)').append('<article>'
            + '<h2>' + titular + '</h2>'
            + '<h3>' + entradilla + '</h3>'
            + '<p>Autor: ' + autor + '</p>'
            + '<p>' + texto + '</p>'
            + '</article>');
    }
}