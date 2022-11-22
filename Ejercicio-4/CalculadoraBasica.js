class CalculadoraBasica {

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
        try{
            this.memory = eval(this.memory.concat("-", this.display.value)).toString();
        } catch(err) {
            this.display.value = "Syntax error";
        }
    }

    memPlus() {
        try{
            this.memory = eval(this.memory.concat("+", this.display.value)).toString();
        } catch(err) {
            this.display.value = "Syntax error";
        }
    }

//  Operations
    addition() {
        this.display.value = this.display.value.concat("+");
    }

    subtraction() {
        this.display.value = this.display.value.concat("-");
    }

    multiplication() {
        this.display.value = this.display.value.concat("*");
    }

    division() {
        this.display.value = this.display.value.concat("/");
    }

//  Symbols
    number(number) {
        if(this.display.value == "0") {
            this.display.value = "";
        } 
        this.display.value = this.display.value.concat(number);
    }

    period() {
        this.display.value = this.display.value.concat(".");
    }

//  Other functions
    clear() {
        this.display.value = "0";
    }

    equals() {
        try {
            this.display.value = eval(this.display.value).toString();
        } catch (err) {
            this.display.value = "Syntax error";
        }
    }

}