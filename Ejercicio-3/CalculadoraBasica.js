class Calculadora {
    memory = "0";
    display = document.getElementById("display");

    constructor() {
        this.clear();
    }

    //  Memory
    memRecovery() {
        this.display.value = this.memory;
    }

    memMinus() {
        try {
            this.memory = eval(this.memory.concat("-", this.display.value)).toString();
        } catch (err) {
            this.display.value = "Syntax error";
        }
    }

    memPlus() {
        try {
            this.memory = eval(this.memory.concat("+", this.display.value)).toString();
        } catch (err) {
            this.display.value = "Syntax error";
        }
    }

    //  Operations
    operation(operator) {
        this.display.value = this.display.value.concat(operator);
    }

    invertSign() {
        this.display.value = Number(eval('-(' + this.display.value + ')'));
    }

    sqrt() {
        this.display.value = Math.sqrt(Number(eval(this.display.value)));
    }

    percentage() {
        this.display.value = Number(eval(this.display.value + '*100'));
    }

    //  Symbols
    number(number) {
        if (this.display.value == "0") {
            this.display.value = "";
        }
        this.display.value = this.display.value.concat(number);
    }

    comma() {
        this.display.value = this.display.value.concat(".");
    }

    //  Other functions
    clear() {
        this.display.value = "0";
    }

    clearOne() {
        if (this.display.value.length > 1) {
            this.display.value = this.display.value.slice(0, -1);
        } else {
            this.display.value = "0";
        }
    }

    equals() {
        try {
            this.display.value = Number(eval(this.display.value)).toString();
        } catch (err) {
            this.display.value = "Syntax error";
        }
    }

}

let calculator = new Calculadora();