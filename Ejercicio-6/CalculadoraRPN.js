class CalculadoraRPN {

    line1Display = document.getElementById("line1");
    line2Display = document.getElementById("line2");
    line3Display = document.getElementById("line3");
    line4Display = document.getElementById("line4");
    line5Display = document.getElementById("line5");
    displayLines = Array(this.line1Display, this.line2Display, this.line3Display, this.line4Display, this.line5Display);

    lineNumber1 = document.getElementById("lineNumber1");
    lineNumber2 = document.getElementById("lineNumber2");
    lineNumber3 = document.getElementById("lineNumber3");
    lineNumber4 = document.getElementById("lineNumber4");
    lineNumber5 = document.getElementById("lineNumber5");
    lineNumbers = Array(this.lineNumber1, this.lineNumber2, this.lineNumber3, this.lineNumber4, this.lineNumber5);

    display = document.getElementById("resultDisplay");

    stack = new StackLIFO();

    constructor() {
        this.updateDisplay();
        this.altOff();
    }


    updateDisplay() {
        let size = this.stack.size();

        for (let i = 0; i < 5; i++) {
            if (this.stack.search(size - 1 - i) == undefined) {
                this.displayLines[i].value = "";
            } else {
                this.displayLines[i].value = this.stack.search(size - 1 - i);
            }
        }
    }

    // Alt
    altOn() {
        this.alt = true;
        let hiddenItems = document.getElementsByClassName("altOff");
        let visibleItems = document.getElementsByClassName("altOn");
        for (let i = 0; i < hiddenItems.length; i++) {
            hiddenItems.item(i).setAttribute("hidden", "");
        }
        for (let i = 0; i < visibleItems.length; i++) {
            visibleItems.item(i).removeAttribute("hidden");
        }
    }

    altOff() {
        this.alt = false;
        let visibleItems = document.getElementsByClassName("altOff");
        let hiddenItems = document.getElementsByClassName("altOn");
        for (let i = 0; i < hiddenItems.length; i++) {
            hiddenItems.item(i).setAttribute("hidden", "");
        }
        for (let i = 0; i < visibleItems.length; i++) {
            visibleItems.item(i).removeAttribute("hidden");
        }
    }

    // Stack lines
    enter() {
        this.stack.push(parseFloat(this.display.value));
        this.updateDisplay();
        this.display.value = "0";
    }

    removeLine() {
        this.stack.pop();
        this.updateDisplay();
    }

    // Display
    number(number) {
        if (this.display.value == "0") {
            this.display.value = "";
        }
        this.display.value = this.display.value.concat(number);
    }

    period() {
        this.display.value = this.display.value.concat(".");
    }

    // Basic operations
    addition() {
        this.doubleLineOperation((a, b) => a + b);
    }

    subtraction() {
        this.doubleLineOperation((a, b) => a - b);
    }

    multiplication() {
        this.doubleLineOperation((a, b) => a * b);
    }

    division() {
        this.doubleLineOperation((a, b) => a / b);
    }

    exp() {
        this.doubleLineOperation((a, b) => a ** b);
    }

    // Scientific operations
    pi() {
        this.number(Math.PI);
    }

    e() {
        this.number(Math.E);
    }

    random() {
        this.number(Math.random());
    }

    logarithm() {
        this.singleLineOperation(x => Math.log10(x));
    }

    tenToX() {
        this.singleLineOperation(x => 10 ** x);
    }

    naturalLogarithm() {
        this.singleLineOperation(x => Math.log(x));
    }

    eToX() {
        this.singleLineOperation(x => Math.E ** x);
    }

    invert() {
        this.singleLineOperation(x => 1 / x);
    }

    factorial() {
        this.singleLineOperation(x => this.factorialize(x));
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

    sine() {
        this.singleLineOperation(x => Math.sin(x));
    }

    cosine() {
        this.singleLineOperation(x => Math.cos(x));
    }

    tangent() {
        this.singleLineOperation(x => Math.tan(x));
    }

    arcsine() {
        this.singleLineOperation(x => 1 / Math.sin(x));
    }

    arccosine() {
        this.singleLineOperation(x => 1 / Math.cos(x));
    }

    arctangent() {
        this.singleLineOperation(x => 1 / Math.tan(x));
    }

    invertSign() {
        this.singleLineOperation(x => -x);
    }

    squareRoot() {
        this.singleLineOperation(x => Math.sqrt(x));
    }

    square() {
        this.singleLineOperation(x => x ** 2);
    }

    cubeRoot() {
        this.singleLineOperation(x => Math.cbrt(x));
    }

    cube() {
        this.singleLineOperation(x => x ** 3);
    }

    // Other functions
    delete() {
        if (this.display.value.length > 1) {
            this.display.value = this.display.value.slice(0, -1);
        } else {
            this.display.value = "0";
        }
    }

    clear() {
        this.display.value = "0";
    }

    singleLineOperation(operation) {
        if (this.stack.size() >= 1) {
            this.stack.push(operation(this.stack.pop()));
            this.updateDisplay();
        }
    }

    doubleLineOperation(operation) {
        if (this.stack.size() >= 2) {
            let b = this.stack.pop();
            let a = this.stack.pop();
            this.stack.push(operation(a, b));
            this.updateDisplay();
        }
    }

}

class StackLIFO {

    data = new Array();

    push(element) {
        this.data.push(element);
    }

    pop() {
        return this.data.pop();
    }

    peak() {
        return this.data.peak();
    }

    empty() {
        this.data = new Array();
    }

    search(index) {
        return this.data[index];
    }

    size() {
        return this.data.length;
    }
}