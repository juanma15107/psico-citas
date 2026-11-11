const emociones = [

    {
        emoji: "😊",
        nombre: "Alegría",
        descripcion: "La alegría nos ayuda a disfrutar los momentos positivos."
    },

    {
        emoji: "😢",
        nombre: "Tristeza",
        descripcion: "La tristeza es una emoción normal ante pérdidas o dificultades."
    },

    {
        emoji: "😡",
        nombre: "Enojo",
        descripcion: "El enojo aparece cuando sentimos injusticia o frustración."
    },

    {
        emoji: "😨",
        nombre: "Miedo",
        descripcion: "El miedo nos ayuda a identificar posibles peligros."
    },

    {
        emoji: "😌",
        nombre: "Calma",
        descripcion: "La calma favorece la concentración y el bienestar."
    },

    {
        emoji: "😍",
        nombre: "Cariño",
        descripcion: "El cariño fortalece nuestras relaciones con los demás."
    },

    {
        emoji: "😎",
        nombre: "Confianza",
        descripcion: "La confianza nos ayuda a creer en nuestras capacidades."
    },

    {
        emoji: "🤔",
        nombre: "Reflexión",
        descripcion: "Reflexionar nos ayuda a comprender mejor nuestras decisiones."
    }

];

let cartas = [];
let primeraCarta = null;
let segundaCarta = null;

let bloqueado = false;
let movimientos = 0;
let parejas = 0;

const tablero =
    document.getElementById("tablero");

const mensaje =
    document.getElementById("mensaje");

function iniciarJuego() {

    cartas = [...emociones, ...emociones];

    cartas.sort(() => Math.random() - 0.5);

    tablero.innerHTML = "";

    movimientos = 0;
    parejas = 0;

    document.getElementById("movimientos").textContent = 0;
    document.getElementById("parejas").textContent = 0;

    mensaje.textContent = "";

    cartas.forEach((emocion) => {

        const carta =
            document.createElement("div");

        carta.classList.add("carta");

        carta.dataset.emoji =
            emocion.emoji;

        carta.dataset.nombre =
            emocion.nombre;

        carta.dataset.descripcion =
            emocion.descripcion;

        carta.textContent = "❓";

        carta.addEventListener(
            "click",
            voltearCarta
        );

        tablero.appendChild(carta);

    });

}

function voltearCarta() {

    if (bloqueado) return;

    if (this.classList.contains("abierta")) return;

    if (this.classList.contains("encontrada")) return;

    this.textContent =
        this.dataset.emoji;

    this.classList.add("abierta");

    if (!primeraCarta) {

        primeraCarta = this;

        return;

    }

    segundaCarta = this;

    movimientos++;

    document.getElementById("movimientos")
        .textContent = movimientos;

    verificarPareja();

}

function verificarPareja() {

    if (
        primeraCarta.dataset.emoji ===
        segundaCarta.dataset.emoji
    ) {

        primeraCarta.classList.add("encontrada");
        segundaCarta.classList.add("encontrada");

        mensaje.innerHTML =

            "✔ " +
            primeraCarta.dataset.nombre +
            "<br>" +
            primeraCarta.dataset.descripcion;

        parejas++;

        document.getElementById("parejas")
            .textContent = parejas;

        primeraCarta = null;
        segundaCarta = null;

        if (parejas === 8) {

            mensaje.innerHTML +=
                "<br><br>🏆 ¡Has completado el memorama!";

        }

    }

    else {

        bloqueado = true;

        setTimeout(() => {

            primeraCarta.textContent = "❓";
            segundaCarta.textContent = "❓";

            primeraCarta.classList.remove("abierta");
            segundaCarta.classList.remove("abierta");

            primeraCarta = null;
            segundaCarta = null;

            bloqueado = false;

        }, 1000);

    }

}

document
    .getElementById("reiniciar")
    .addEventListener(
        "click",
        iniciarJuego
    );

iniciarJuego();