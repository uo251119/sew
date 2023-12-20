class Sudoku {

    filas = 9;
    columnas = 9;

    tableroString = "3.4.69.5....27...49.2..4....2..85.198.9...2.551.39..6....8..5.32...46....4.75.9.6";

    constructor() {
        this.tablero = [this.filas];

        let casillaIndex = 0;

        for (let i = 0; i < this.filas; i++) {
            this.tablero[i] = [this.columnas];

            for (let j = 0; j < this.columnas; j++) {
                if (this.tableroString[casillaIndex] == ".") {
                    this.tablero[i][j] = 0;
                } else {
                    this.tablero[i][j] = parseInt(this.tableroString[casillaIndex]);
                }

                casillaIndex++;
            }
        }
    }

    createStructure() {
        for (let i = 0; i < this.filas; i++) {
            for (let j = 0; j < this.columnas; j++) {
                let newCell = document.createElement("p");

                document.getElementsByTagName("main")[0].appendChild(newCell);
            }
        }
    }

    paintSudoku() {
        this.createStructure();

        let tableroElement = document.getElementsByTagName("main")[0]

        let rowCounter = 0;
        for (let i = 0; i < this.filas; i++) {
            for (let j = 0; j < this.columnas; j++) {
                let cell = tableroElement.getElementsByTagName("p")[rowCounter];

                if (this.tablero[i][j] == 0) {
                    cell.onclick = () => {
                        Array.from(document.getElementsByTagName("p")).forEach(element => {
                            if (element.getAttribute("data-state") == "clicked") {
                                element.removeAttribute("data-state");
                            }
                        });

                        cell.setAttribute("data-state", "clicked");
                    };
                } else {
                    cell.appendChild(document.createTextNode(this.tablero[i][j]));
                    cell.setAttribute("data-state", "blocked");
                }

                rowCounter++;
            }
        }
    }

    introduceNumber(number) {
        let cells = document.getElementsByTagName("p");

        for (let i = 0; i < this.filas; i++) {
            for (let j = 0; j < this.columnas; j++) {
                let cell = cells[i * this.filas + j];
                if (cell.getAttribute("data-state") == "clicked") {
                    if (this.checkFila(i, number) && this.checkColumna(j, number) && this.checkSubcuadricula(i, j, number)) {
                        cell.onclick = null;
                        cell.setAttribute("data-state", "correct");

                        cell.appendChild(document.createTextNode(number));
                    }
                }
            }
        }

        let completado = true;
        Array.from(cells).forEach(element => {
            if (element.getAttribute("data-state") == null) {
                completado = false;
            }
        });

        if (completado) {
            alert("Sudoku completado!");
        }
    }

    checkFila(fila, number) {
        let cells = document.getElementsByTagName("p");

        for (let i = 0; i < this.columnas; i++) {
            if (cells[fila * this.filas + i].textContent == number.toString()) {
                return false;
            }
        }

        return true;
    }

    checkColumna(columna, number) {
        let cells = document.getElementsByTagName("p");

        for (let i = 0; i < this.filas; i++) {
            if (cells[i * this.filas + columna].textContent == number.toString()) {
                return false;
            }
        }

        return true;
    }

    checkSubcuadricula(fila, columna, number) {
        let filaInicial;
        let columnaInicial;

        if (fila > 5) {
            filaInicial = 6;
        } else if (fila > 2) {
            filaInicial = 3;
        } else {
            filaInicial = 0;
        }

        if (columna > 5) {
            columnaInicial = 6;
        } else if (columna > 2) {
            columnaInicial = 3;
        } else {
            columnaInicial = 0;
        }

        let cells = document.getElementsByTagName("p");

        for (let i = filaInicial; i < filaInicial + 3; i++) {
            for (let j = columnaInicial; j < columnaInicial + 3; j++) {
                if (cells[i * this.filas + j].textContent == number.toString()) {
                    return false;
                }
            }
        }

        return true;
    }
}