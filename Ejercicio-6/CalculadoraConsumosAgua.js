class CalculadoraConsumosAgua extends CalculadoraRPN {

    //selectedDisplay;

    consumersDisplay = document.getElementById("consumers");
    consumerConsumptionDisplay = document.getElementById("consumerConsumption");
    leaksDisplay = document.getElementById("leaks");
    daysDisplay = document.getElementById("days");

    diaryConsumptionDisplay = document.getElementById("diaryConsumption");
    totalConsumptionDisplay = document.getElementById("totalConsumption");

    constructor() {
        super();
        this.editConsumers();
    }

    hideAllActiveEditButtons() {
        let inactiveEditButtons = document.getElementsByClassName("editButton");
        let activeEditButtons = document.getElementsByClassName("editButtonActive");
        for (let i = 0; i < inactiveEditButtons.length; i++) {
            inactiveEditButtons.item(i).removeAttribute("hidden");
            inactiveEditButtons.item(i).setAttribute("visible", "");
        }
        for (let i = 0; i < activeEditButtons.length; i++) {
            activeEditButtons.item(i).removeAttribute("visible");
            activeEditButtons.item(i).setAttribute("hidden", "");
        }
    }

    // Toggle functionality
    editConsumers() {
        this.hideAllActiveEditButtons();

        let editButton = document.getElementById("editConsumers");
        editButton.removeAttribute("visible");
        editButton.setAttribute("hidden", "");

        let editButtonActive = document.getElementById("editConsumersActive");
        editButtonActive.removeAttribute("hidden");
        editButtonActive.setAttribute("visible", "");

        super.display = this.consumersDisplay;
    }

    editConsumerConsumption() {
        this.hideAllActiveEditButtons();

        let editButton = document.getElementById("editConsumerConsumption");
        editButton.removeAttribute("visible");
        editButton.setAttribute("hidden", "");

        let editButtonActive = document.getElementById("editConsumerConsumptionActive");
        editButtonActive.removeAttribute("hidden");
        editButtonActive.setAttribute("visible", "");

        super.display = this.consumerConsumptionDisplay;
    }

    editLeaks() {
        this.hideAllActiveEditButtons();

        let editButton = document.getElementById("editLeaks");
        editButton.removeAttribute("visible");
        editButton.setAttribute("hidden", "");

        let editButtonActive = document.getElementById("editLeaksActive");
        editButtonActive.removeAttribute("hidden");
        editButtonActive.setAttribute("visible", "");

        super.display = this.leaksDisplay;
    }

    editDays() {
        this.hideAllActiveEditButtons();

        let editButton = document.getElementById("editDays");
        editButton.removeAttribute("visible");
        editButton.setAttribute("hidden", "");

        let editButtonActive = document.getElementById("editDaysActive");
        editButtonActive.removeAttribute("hidden");
        editButtonActive.setAttribute("visible", "");

        super.display = this.daysDisplay;
    }

    get() {
        if (this.stack.size() > 0) {
            this.display.value = this.stack.pop();
            this.updateDisplay();
        }

        super.altOff();
    }

    // Other functionality
    calculate() {
        try {
            this.diaryConsumptionDisplay.value = eval(
                "((" + this.consumersDisplay.value + ")*(" + this.consumerConsumptionDisplay.value + "))+("
                + this.leaksDisplay.value + ")");
            this.totalConsumptionDisplay.value = eval(
                "(" + this.diaryConsumptionDisplay.value + ")*(" + this.daysDisplay.value + ")");
        } catch (err) {
            // Do nothing
        }
    }

}

let calculator = new CalculadoraConsumosAgua();