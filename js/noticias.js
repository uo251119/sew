
class Noticias {
    API_KEY = '1a56190e419846deae0203df131c6bea';
    date = new Date();

    cargarDatos(query) {
        this.date.setMonth(this.date.getMonth() - 1);

        this.url = 'https://newsapi.org/v2/everything?q=' + query + '&from=' + this.date + '&sortBy=publishedAt&apiKey=' + this.API_KEY;
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
        $('#noticiaCoaña').empty();

        this.datos.articles.forEach(article => {
            $('#noticiaCoaña').append('<p>' + article.title + ' - ' + article.source.name + '</p>');
        });

        if (this.datos.articles.length == 0) {
            $('#noticiaCoaña').append('<p>No se han encontrado noticias</p>');
        }

    }
}

let noticias = new Noticias();
noticias.cargarDatos('coaña');