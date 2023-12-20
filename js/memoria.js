class Memoria {

    elements = [
        { "element": "HTML5", "source": "https://upload.wikimedia.org/wikipedia/commons/3/38/HTML5_Badge.svg" },
        { "element": "HTML5", "source": "https://upload.wikimedia.org/wikipedia/commons/3/38/HTML5_Badge.svg" },
        { "element": "CSS3", "source": "https://upload.wikimedia.org/wikipedia/commons/6/62/CSS3_logo.svg" },
        { "element": "CSS3", "source": "https://upload.wikimedia.org/wikipedia/commons/6/62/CSS3_logo.svg" },
        { "element": "JS", "source": "https://upload.wikimedia.org/wikipedia/commons/b/ba/Javascript_badge.svg" },
        { "element": "JS", "source": "https://upload.wikimedia.org/wikipedia/commons/b/ba/Javascript_badge.svg" },
        { "element": "PHP", "source": "https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" },
        { "element": "PHP", "source": "https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" },
        { "element": "SVG", "source": "https://upload.wikimedia.org/wikipedia/commons/4/4f/SVG_Logo.svg" },
        { "element": "SVG", "source": "https://upload.wikimedia.org/wikipedia/commons/4/4f/SVG_Logo.svg" },
        { "element": "W3C", "source": "https://upload.wikimedia.org/wikipedia/commons/5/5e/W3C_icon.svg" },
        { "element": "W3C", "source": "https://upload.wikimedia.org/wikipedia/commons/5/5e/W3C_icon.svg" },
    ];

    constructor() {
        this.hasFlippedCard = false;
        this.lockBoard = false;
        this.firstCard = null;
        this.secondCard = null;

        this.shuffleElements();
        this.createElements();

        this.addEventListeners();
    }

    shuffleElements() {
        let i = this.elements.length, j;

        while (i > 0) {
            j = Math.floor(Math.random() * i);
            i--;

            [this.elements[i], this.elements[j]] = [this.elements[j], this.elements[i]]
        }
    }

    unflipCards() {
        this.lockBoard = true;

        setTimeout((firstCard, secondCard) => {
            firstCard.setAttribute("data-state", "");
            secondCard.setAttribute("data-state", "");
        }, 1000, this.firstCard, this.secondCard)


        this.resetBoard();
    }

    resetBoard() {
        console.log("reset");

        this.firstCard = null;
        this.secondCard = null;
        this.hasFlippedCard = false;
        this.lockBoard = false;
    }

    checkForMatch() {
        if (this.firstCard.getAttribute("data-element") == this.secondCard.getAttribute("data-element")) {
            this.disableCards();
        } else {
            this.unflipCards();
        }
    }

    disableCards() {
        this.firstCard.setAttribute("data-state", "revealed");
        this.secondCard.setAttribute("data-state", "revealed");

        this.resetBoard();
    }

    createElements() {
        this.elements.forEach((card) => {
            let newCard = document.createElement("article");
            newCard.setAttribute("data-element", card.element);

            let cardHeader = document.createElement("h3");
            cardHeader.appendChild(document.createTextNode("Tarjeta de memoria"));

            let cardImage = document.createElement("img");
            cardImage.setAttribute("src", card.source);
            cardImage.setAttribute("alt", card.element);

            newCard.appendChild(cardHeader);
            newCard.appendChild(cardImage);

            document.getElementsByTagName("section")[1].getElementsByTagName("section")[0].appendChild(newCard);
        });
    }

    addEventListeners() {
        let cards = document.getElementsByTagName("article");

        Array.prototype.forEach.call(cards, (card) => {
            card.onclick = this.flipCard.bind(card, this);
        });
    }

    flipCard(game) {
        if ((this.getAttribute("data-state") == "revealed")
            || (game.lockBoard)
            || (this == game.firstCard)) {
            return;
        } else {
            this.setAttribute("data-state", "flip");

            if (game.hasFlippedCard) {
                game.secondCard = this;

                game.checkForMatch();
            } else {
                game.firstCard = this;
                game.hasFlippedCard = true;
            }
        }
    }

}