class CalculadoraCientifica extends CalculadoraBasica {

    constructor() {
        super();
        this.altOff();
    }

    alt = false;

    // Alt
    altOn() {
        this.alt = true;
        var hiddenItems = document.getElementsByClassName("altOff");
        var visibleItems = document.getElementsByClassName("altOn");
        for(var i = 0; i < hiddenItems.length; i++) {
            hiddenItems.item(i).setAttribute("hidden", "");      
        }
        for(i = 0; i < visibleItems.length; i++) {
            visibleItems.item(i).removeAttribute("hidden");      
        }
    }

    altOff() {
        this.alt = false;
        var visibleItems = document.getElementsByClassName("altOff");
        var hiddenItems = document.getElementsByClassName("altOn");
        for(var i = 0; i < hiddenItems.length; i++) {
            hiddenItems.item(i).setAttribute("hidden", "");      
        }
        for(i = 0; i < visibleItems.length; i++) {
            visibleItems.item(i).removeAttribute("hidden");      
        }
    }

    // Symbols
    delete() {
        if (this.display.value.length > 1) {
            this.display.value = this.display.value.slice(0, -1);
        } else {
            this.display.value = "0";
        }
    }

    symbol(symbol) {
        this.display.value = this.display.value.concat(symbol);
    }

    pi() {
        this.number(Math.PI);
    }

    e() {
        this.number(Math.E);
    }

    random() {
        this.number(Math.random());
    }

    // Functions
    logarithm() {
        this.display.value = (Math.log10(eval(this.display.value))).toString();
    }

    tenToX() {
        this.display.value = (10 ** (eval(this.display.value))).toString();
    }

    naturalLogarithm() {
        this.display.value = (Math.log(eval(this.display.value))).toString();
    }

    eToX() {
        this.display.value = (Math.E ** (eval(this.display.value))).toString();
    }

    invert() {
        this.display.value = eval("1/" + this.display.value).toString();
    }

    factorial() {
        var num  = parseInt(eval(this.display.value).toString());
        this.display.value = this.factorialize(num).toString();
    }

    factorialize(num) {
        if (num < 0) {
            return -1;
        } else if (num == 0) {
            return 1;
        } else {
            return (num * this.factorialize(num - 1));
        }
    }

    sine()  {
        this.display.value = (Math.sin(eval(this.display.value))).toString();
    }

    cosine() {
        this.display.value = (Math.cos(eval(this.display.value))).toString();
    }

    tangent() {
        this.display.value = (Math.tan(eval(this.display.value))).toString();
    }

    arcsine()  {
        this.display.value = (1 / Math.sin(eval(this.display.value))).toString();
    }

    arccosine() {
        this.display.value = (1 / Math.cos(eval(this.display.value))).toString();
    }

    arctangent() {
        this.display.value = (1 / Math.tan(eval(this.display.value))).toString();
    }

    invertSign() {
        this.display.value = "-(" + this.display.value + ")";
    }

    squareRoot() {
        this.display.value = (Math.sqrt(eval(this.display.value))).toString();
    }

    square() {
        this.display.value = ((eval(this.display.value)) ** 2).toString();
    }

    cubeRoot() {
        this.display.value = (Math.cbrt(eval(this.display.value))).toString();
    }

    cube() {
        this.display.value = ((eval(this.display.value)) ** 3).toString();
    }

    exp() {
        this.display.value = this.display.value.concat("**");
    }

    // Memory
    memIn() {
        this.memory = eval(this.display.value);
    }

    memOut() {
        this.number(this.memory);
    }
}

var calculator = new CalculadoraCientifica();