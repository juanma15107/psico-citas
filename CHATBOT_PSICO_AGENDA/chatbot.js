
// Identifica en qué página se encuentra el chatbot
const script = document.currentScript;
const contexto = script.dataset.contexto || "inicio";

// Direcciones según la página
const rutas = {
    inicio: {
        solicitud: "./Paginas/iniciar_sesion.php",
        mensaje: "Para solicitar una cita, primero debes iniciar sesión."
    },
    estudiante: {
        solicitud: "./SolicitarCita(panelEstudiante).php",
        mensaje: "Puedes solicitar tu cita desde el formulario de estudiantes."
    },
    docente: {
        solicitud: "./SolicitarAcompañamiento(panelDocente).php",
        mensaje: "Puedes solicitar acompañamiento desde el formulario de docentes."
    }
};

// Selecciona las rutas correspondientes
const pagina = rutas[contexto] || rutas.inicio;

// Crea el espacio del chatbot
const contenedor = document.createElement("div");
contenedor.innerHTML = `
    <button class="psicobot-boton" id="psicobotAbrir">💬</button>

    <div class="psicobot-ventana" id="psicobotVentana">

        <div class="psicobot-encabezado">
            <div>
                <strong>PsicoBot 💜</strong><br>
                <small>Estoy aquí para orientarte</small>
            </div>

            <button class="psicobot-cerrar" id="psicobotCerrar">×</button>
        </div>

        <div class="psicobot-mensajes" id="psicobotMensajes"></div>

        <div class="psicobot-opciones" id="psicobotOpciones"></div>

    </div>
`;

document.body.appendChild(contenedor);

// Crea la bolita para abrir el juego
const botonJuego = document.createElement("button");

botonJuego.className = "psicobot-juego";
botonJuego.innerHTML = "🎮";
botonJuego.title = "Jugar Memorama de Emociones";

// Abre el juego en otra página
botonJuego.addEventListener("click", function () {
    window.location.href = "./JUEGUITO PSICO_CITAS/memoramaEmociones.html";
});

document.body.appendChild(botonJuego);

// Elementos del chatbot
const botonAbrir = document.getElementById("psicobotAbrir");
const botonCerrar = document.getElementById("psicobotCerrar");
const ventana = document.getElementById("psicobotVentana");
const mensajes = document.getElementById("psicobotMensajes");
const opciones = document.getElementById("psicobotOpciones");

// Abre el chatbot
botonAbrir.addEventListener("click", function () {
    ventana.style.display = "flex";

    if (mensajes.innerHTML === "") {
        menuPrincipal();
    }
});

// Cierra el chatbot
botonCerrar.addEventListener("click", function () {
    ventana.style.display = "none";
});

// Muestra un mensaje
function mensajeBot(texto) {
    const mensaje = document.createElement("div");
    mensaje.className = "psicobot-mensaje";
    mensaje.textContent = texto;
    mensajes.appendChild(mensaje);
    mensajes.scrollTop = mensajes.scrollHeight;
}

// Crea los botones de respuesta
function mostrarOpciones(lista) {
    opciones.innerHTML = "";

    lista.forEach(function (opcion) {
        const boton = document.createElement("button");
        boton.textContent = opcion.texto;

        boton.addEventListener("click", function () {
            opciones.innerHTML = "";
            opcion.accion();
        });

        opciones.appendChild(boton);
    });
}

// Menú principal
function menuPrincipal() {
    mensajeBot("¡Hola! 💜 Soy PsicoBot, tu asistente de Psico-Agenda.");
    mensajeBot("¿En qué puedo ayudarte hoy?");

    mostrarOpciones([
        {
            texto: "¿Cómo me siento hoy?",
            accion: sentimientos
        },
        {
            texto: "¿Qué es Psico-Agenda?",
            accion: explicar
        },
        {
            texto: "Quiero solicitar ayuda",
            accion: solicitarAyuda
        },
        {
            texto: "¿Qué servicios ofrecen?",
            accion: servicios
        }
    ]);
}

// Preguntas sobre cómo se siente la persona
function sentimientos() {
    mensajeBot("Cuéntame, ¿cómo te sientes hoy?");

    mostrarOpciones([
        {
            texto: "Me siento bien 😊",
            accion: function () {
                mensajeBot("¡Me alegra mucho! Recuerda que también es importante cuidar tu bienestar emocional.");
                volverMenu();
            }
        },
        {
            texto: "No me siento muy bien 😔",
            accion: function () {
                mensajeBot("Lamento que estés pasando por un momento difícil. 💜 No tienes que afrontar todo a solas.");
                mensajeBot("Puedes acudir al equipo de apoyo psicológico de tu institución.");
                mostrarOpciones([
                    {
                        texto: "Quiero solicitar ayuda",
                        accion: solicitarAyuda
                    },
                    {
                        texto: "Volver al menú",
                        accion: menuPrincipal
                    }
                ]);
            }
        },
        {
            texto: "No sé cómo me siento 🤔",
            accion: function () {
                mensajeBot("No pasa nada. A veces es difícil identificar nuestras emociones. Puedes tomarte un momento para reconocer lo que estás sintiendo.");
                volverMenu();
            }
        }
    ]);
}

// Explica qué es Psico-Agenda
function explicar() {
    mensajeBot("Psico-Agenda es una plataforma que facilita el acceso al acompañamiento psicológico dentro de la institución.");
    mensajeBot("Desde aquí puedes conocer los servicios y realizar solicitudes de apoyo.");

    volverMenu();
}

// Explica los servicios
function servicios() {
    mensajeBot("En Psico-Agenda puedes encontrar opciones como:");

    mensajeBot("• Atención psicológica individual.\n• Charlas de bienestar emocional.\n• Talleres de convivencia escolar.\n• Acompañamiento grupal.");

    volverMenu();
}

// Orienta para solicitar ayuda
function solicitarAyuda() {
    mensajeBot(pagina.mensaje);

    mostrarOpciones([
        {
            texto: "Continuar",
            accion: function () {
                window.location.href = pagina.solicitud;
            }
        },
        {
            texto: "Volver al menú",
            accion: menuPrincipal
        }
    ]);
}

// Botón para volver al menú
function volverMenu() {
    mostrarOpciones([
        {
            texto: "Volver al menú principal",
            accion: menuPrincipal
        }
    ]);
}
