class Fecha {
    startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        var m = this.checkTime(m);
        var s = this.checkTime(s);
        document.getElementById('reloj').innerHTML = h + ":" + m + ":" + s;
    }

    constructor() {
        var today = new Date();
        var m = today.getMonth() + 1;
        var mes = (m < 10) ? '0' + m : m;
        document.getElementById("fechaDiaActual").innerHTML = today.getDate() + '/' + mes + '/' + today.getFullYear();

        setTimeout(this.startTime(), 500);
    }

    checkTime(i) {
        if (i < 10) { i = "0" + i; } return i;
    }
}

let fecha = new Fecha();