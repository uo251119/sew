class Crucigrama {

    EASY_BOARD = '4,*,.,=,12,#,#,#,5,#,#,*,#,/,#,#,#,*,4,-,.,=,.,#,15,#,.,*,#,=,#,=,#,/,#,=,.,#,3,#,4,*,.,=,20,=,#,#,#,#,#,=,#,#,8,#,9,-,.,=,3,#,.,#,#,-,#,+,#,#,#,*,6,/,.,=,.,#,#,#,.,#,#,=,#,=,#,#,#,=,#,#,6,#,8,*,.,=,16';
    INTERMEDIATE_BOARD = '12,*,.,=,36,#,#,#,15,#,#,*,#,/,#,#,#,*,.,-,.,=,.,#,55,#,.,*,#,=,#,=,#,/,#,=,.,#,15,#,9,*,.,=,45,=,#,#,#,#,#,=,#,#,72,#,20,-,.,=,11,#,.,#,#,-,#,+,#,#,#,*,56,/,.,=,.,#,#,#,.,#,#,=,#,=,#,#,#,=,#,#,12,#,16,*,.,=,32';
    HARD_BOARD = '4,.,.,=,36,#,#,#,25,#,#,*,#,.,#,#,#,.,.,-,.,=,.,#,15,#,.,*,#,=,#,=,#,.,#,=,.,#,18,#,6,*,.,=,30,=,#,#,#,#,#,=,#,#,56,#,9,-,.,=,3,#,.,#,#,*,#,+,#,#,#,*,20,.,.,=,18,#,#,#,.,#,#,=,#,=,#,#,#,=,#,#,18,#,24,.,.,=,7';

    level;

    board = '';
    columns = 9;
    rows = 11;
    init_time;
    end_time;

    boardCells;

    constructor() {
        this.boardCells = [this.rows];
        for (let i = 0; i < this.rows; i++) {
            this.boardCells[i] = [this.columns];
        }
    }

    getNivel() {
        switch (this.level) {
            case 1:
                return 'fácil';
            case 2:
                return 'intermedio';
            case 3:
                return 'difícil';
        }
    }

    start(level) {
        $('section button').remove();

        this.level = level;
        switch (level) {
            case 1:
                this.board = this.EASY_BOARD;
                break;
            case 2:
                this.board = this.INTERMEDIATE_BOARD
                break;
            case 3:
                this.board = this.HARD_BOARD
                break;
        }

        let cellIndex = 0;
        let cellContents = this.board.split(',');

        for (let i = 0; i < this.rows; i++) {
            for (let j = 0; j < this.columns; j++) {
                if (cellContents[cellIndex] == '.') {
                    this.boardCells[i][j] = 0;
                } else if (cellContents[cellIndex] == '#') {
                    this.boardCells[i][j] = -1;
                } else if (cellContents[cellIndex]) {
                    this.boardCells[i][j] = cellContents[cellIndex];
                }

                cellIndex++;
            }
        }

        this.paintMathword();
    }

    paintMathword() {
        for (let i = 0; i < this.rows; i++) {
            for (let j = 0; j < this.columns; j++) {
                let newCell = document.createElement('p');

                if (this.boardCells[i][j] == 0) {
                    newCell.onclick = () => {
                        Array.from(document.getElementsByTagName('p')).forEach(element => {
                            if (element.getAttribute('data-state') == 'clicked') {
                                element.removeAttribute('data-state');
                            }
                        });

                        newCell.setAttribute('data-state', 'clicked');
                    };
                }
                if (this.boardCells[i][j] == -1) {
                    newCell.setAttribute('data-state', 'empty');
                } else if (this.boardCells[i][j] != 0) {
                    newCell.appendChild(document.createTextNode(this.boardCells[i][j]));
                    newCell.setAttribute('data-state', 'blocked');
                }

                document.getElementsByTagName('main')[0].appendChild(newCell);
            }
        }

        this.init_time = (new Date()).getTime();
    }

    check_win_condition() {
        for (let i = 0; i < this.rows; i++) {
            for (let j = 0; j < this.columns; j++) {
                if (this.boardCells[i][j] == 0) {
                    return false;
                }
            }
        }

        return true;
    }

    calculate_date_difference() {
        let dateDifference = new Date(this.end_time - this.init_time);
        return (dateDifference.getHours() - 1).toString().padStart(2, '0')
            + ':' + dateDifference.getMinutes().toString().padStart(2, '0')
            + ':' + dateDifference.getSeconds().toString().padStart(2, '0');
    }

    introduceElement(elementString) {
        if (!elementString.match(/^[\d+\-*/]$/g)) {
            return;
        }

        let htmlCells = document.getElementsByTagName('main')[0].getElementsByTagName('p');

        let cellRow;
        let cellColumn;
        for (let i = 0; i < this.rows; i++) {
            for (let j = 0; j < this.columns; j++) {

                if (htmlCells[(i * this.columns) + j].getAttribute('data-state') == 'clicked') {
                    this.boardCells[i][j] = elementString;

                    cellRow = i;
                    cellColumn = j;
                }
            }
        }

        let expression_row = this.checkRowExpression(cellColumn, cellRow);
        let expression_col = this.checkColumnExpression(cellColumn, cellRow);

        if (expression_row && expression_col) {
            htmlCells[(cellRow * this.columns) + cellColumn].setAttribute('data-state', 'correct');
            htmlCells[(cellRow * this.columns) + cellColumn].appendChild(document.createTextNode(this.boardCells[cellRow][cellColumn]));
            htmlCells[(cellRow * this.columns) + cellColumn].onclick = null;
        } else {
            this.boardCells[cellRow][cellColumn] = 0;
        }

        if (this.check_win_condition()) {
            this.end_time = (new Date()).getTime();

            let dateDifference = this.calculate_date_difference();

            alert('Crucigrama completado. Tiempo empleado: ' + dateDifference);

            this.createRecordForm();
        }
    }

    checkRowExpression(cellColumn, cellRow) {
        let first_number = 0;
        let second_number = 0;
        let expression = 0;
        let result = 0;

        for (let i = cellColumn + 1; i < this.columns; i++) {
            if (this.boardCells[cellRow][i] == -1) {
                return true;
            } else if (this.boardCells[cellRow][i] == "=") {
                first_number = this.boardCells[cellRow][i - 3];
                second_number = this.boardCells[cellRow][i - 1];
                expression = this.boardCells[cellRow][i - 2];
                result = this.boardCells[cellRow][i + 1];

                break;
            }
        }

        if (first_number != 0 && second_number != 0 && expression != 0 && result != 0) {
            return eval([first_number, expression, second_number].join('')) == eval(result);
        }

        return true;
    }

    checkColumnExpression(cellColumn, cellRow) {
        let first_number = 0;
        let second_number = 0;
        let expression = 0;
        let result = 0;

        for (let i = cellRow + 1; i < this.rows; i++) {
            if (this.boardCells[i][cellColumn] == -1) {
                return true;
            } else if (this.boardCells[i][cellColumn] == "=") {
                first_number = this.boardCells[i - 3][cellColumn];
                second_number = this.boardCells[i - 1][cellColumn];
                expression = this.boardCells[i - 2][cellColumn];
                result = this.boardCells[i + 1][cellColumn];

                break;
            }
        }

        if (first_number != 0 && second_number != 0 && expression != 0 && result != 0) {
            return eval([first_number, expression, second_number].join('')) == eval(result);
        }

        return true;
    }

    createRecordForm() {
        let nivel;
        switch (this.level) {
            case 1:
                nivel = "fácil";
                break;
            case 2:
                nivel = "intermedio";
                break;
            case 3:
                nivel = "difícil";
                break;
        }

        let formHtmlString = '<h3>Guarda tu récord</h3>'
            + '<form action="#" method="post" name="record">'
            + '<label for="name">Tu nombre:</label>'
            + '<input id="name" name="name" type="text">'
            + '<label for="surname">Tus apellidos:</label>'
            + '<input id="surname" name="surname" type="text">'
            + '<label for="level">Nivel:</label>'
            + '<input id="level" name="level" type="text" value="' + nivel + '" readonly="readonly">'
            + '<label for="time">Tiempo (s):</label>'
            + '<input id="time" name="time" type="number" value="' + parseInt((this.end_time - this.init_time) / 1000) + '" readonly="readonly">'
            + '<input type="submit" value="Guardar">'
            + '</form>';

        $('body').append(formHtmlString);
    }
}