const cuteAlert = ({
    type,
    title,
    message,
    closeStyle,
    buttonText,
}) => {
    return new Promise((resolve) => {
        const existingAlert = document.querySelector(".alert-wrapper");
        const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];
        const fecha = new Date();

        var fechaActual = fecha.getDate() + " de " + monthNames[fecha.getMonth()] + " de " + fecha.getFullYear()

        if (existingAlert) {
            existingAlert.remove();
        }

        const body = document.querySelector("body");

        const scripts = document.getElementsByTagName("script");

        let src = "";

        for (let script of scripts) {
            if (script.src.includes("cute-alert.js")) {
                src = script.src.substring(0, script.src.lastIndexOf("/"));
            }
        }

        let btnTemplate = `
    <button class="alert-button ${type}-bg ${type}-btn">${buttonText}</button>
    `;

        const template = `
      <div class="alert-wrapper">
        <div class="alert-frame">
          <div class="alert-header ${type}-bg">
            <span class="alert-close ${closeStyle === "circle" ? "alert-close-circle" : "alert-close-default"}">X</span>
            <img class="alert-img" src="${src}js/${type}.svg" />
          </div>
          <div class="alert-body">
            <span class="alert-title">${title}</span>
            <span class="alert-fecha">${fechaActual}</span>
            <span class="alert-message">${message}</span>
            ${btnTemplate}
          </div>
        </div>
      </div>
      `;

        body.insertAdjacentHTML("afterend", template);

        const alertButton = document.querySelector(".alert-button");
        const alertWrapper = document.querySelector(".alert-wrapper");
        const alertFrame = document.querySelector(".alert-frame");
        const alertClose = document.querySelector(".alert-close");

        alertButton.addEventListener("click", () => {
            alertWrapper.remove();
            redireccion();
            resolve();
        });

        alertClose.addEventListener("click", () => {
            alertWrapper.remove();
            redireccion();
            resolve();
        });

        alertWrapper.addEventListener("click", () => {
            alertWrapper.remove();
            redireccion();
            resolve();
        });

        alertFrame.addEventListener("click", (e) => {
            e.stopPropagation();            
            redireccion();
        });
    });
}

//window.location.href="index.php";
function redireccion() {
    window.location.href = "index.php";
}

