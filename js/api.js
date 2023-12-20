class Api {
    loadText(event) {
        event.preventDefault();

        if (event.dataTransfer.items) {
            [...event.dataTransfer.items].forEach((item, i) => {
                if (item.kind === 'file') {
                    const file = item.getAsFile();
                    this.loadFile(file);
                }
            });
        } else {
            [...event.dataTransfer.files].forEach((file, i) => {
                this.loadFile(file);
            });
        }
    }

    loadFile(file) {
        let lector = new FileReader();
        lector.onload = function (evento) {
            document.getElementById("text").innerText = document.getElementById("text").innerText.concat(lector.result);
        }
        lector.readAsText(file);
    }

    copyText() {
        let text = document.getElementById("text");

        text.select();
        text.setSelectionRange(0, 99999);

        navigator.clipboard.writeText(text.value);
    }

    dragOverHandler(event) {
        event.preventDefault();
    }
}