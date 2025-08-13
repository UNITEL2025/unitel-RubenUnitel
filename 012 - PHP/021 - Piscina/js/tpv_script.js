
    //console.log(productos);
    /*const productos = [
      { id: 1, name: 'Café', price: 1.20 },
      { id: 2, name: 'Té', price: 1.00 },
      { id: 3, name: 'Sandwich', price: 3.50 },
      { id: 4, name: 'Agua', price: 0.80 },
      { id: 5, name: 'Refresco', price: 1.50 },
      { id: 6, name: 'Pastel', price: 2.00 }
    ];*/

    let ventaItems = [];

    const productosList = document.getElementById("productosList");
    const detalleVentaBody = document.getElementById("detalleVentaBody");
    const totalDisplay = document.getElementById("totalDisplay");
    const importeRecibidoInput = document.getElementById("importeRecibido");
    const importeDevolverInput = document.getElementById("importeDevolver");
    const numPadButtons = document.querySelectorAll(".num-pad button[data-key]");
    const clearInputBtn = document.getElementById("clearInput");

    function renderProductos() {
      productosList.innerHTML = "";
      productos.forEach((producto) => {
        const btn = document.createElement("button");
        btn.className = "btn btn-outline-primary btn-producto";
        btn.setAttribute("type", "button");
        btn.setAttribute("aria-label", "Añadir "+producto.name+" por "+parseFloat(producto.price).toFixed(2)+" euros");
        btn.innerHTML = "<span>"+producto.name+"</span><span>"+parseFloat(producto.price).toFixed(2)+" €</span>";
        btn.onclick = () => {
          const idx = ventaItems.findIndex(item => item.id === producto.id);
          if (idx > -1) {
            ventaItems[idx].quantity++;
          } else {
            ventaItems.push({...producto, quantity: 1});
          }
          actualizarDetalle();
        };
        productosList.appendChild(btn);
      });
    }

    function actualizarDetalle() {
      detalleVentaBody.innerHTML = "";
      if (ventaItems.length === 0) {
        detalleVentaBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted fst-italic">No hay productos añadidos</td></tr>';
        totalDisplay.textContent = "0.00 €";
        importeDevolverInput.value = "";
        return;
      }

      let total = 0;
      ventaItems.forEach((item, index) => {
        total += item.price * item.quantity;
        const importe = item.price * item.quantity;

        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${item.name}</td>
          <td class="text-center">
            <div class="cantidad-controls" role="group" aria-label="Control de cantidad para ${item.name}">
              <button class="btn btn-sm btn-outline-secondary" aria-label="Disminuir cantidad" data-action="decrease" data-index="${index}">−</button>
              <span aria-live="polite" aria-atomic="true">${item.quantity}</span>
              <button class="btn btn-sm btn-outline-secondary" aria-label="Incrementar cantidad" data-action="increase" data-index="${index}">+</button>
            </div>
          </td>
          <td class="text-end">${importe.toFixed(2)} €</td>
          <td class="text-center">
            <button class="btn btn-danger btn-sm" aria-label="Eliminar ${item.name}" data-action="remove" data-index="${index}">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        `;
        detalleVentaBody.appendChild(tr);
      });

      totalDisplay.textContent = total.toFixed(2) + " €";

      if (importeRecibidoInput.value) calcularDevolucion();

      detalleVentaBody.querySelectorAll("button").forEach(button => {
        const action = button.dataset.action;
        const index = Number(button.dataset.index);

        button.onclick = () => {
          if (action === "increase") {
            ventaItems[index].quantity++;
          } else if (action === "decrease") {
            if (ventaItems[index].quantity > 1) {
              ventaItems[index].quantity--;
            } else {
              ventaItems.splice(index, 1);
            }
          } else if (action === "remove") {
            ventaItems.splice(index, 1);
          }
          actualizarDetalle();
        };
      });
    }

    function calcularDevolucion() {
      let recibido = parseFloat(importeRecibidoInput.value);
      if (isNaN(recibido)) recibido = 0;

      let total = ventaItems.reduce((acc, item) => acc + item.price * item.quantity, 0);
      let devolver = recibido - total;
      importeDevolverInput.value = devolver >= 0 ? devolver.toFixed(2) : "0.00";
    }

    numPadButtons.forEach(button => {
      button.addEventListener("click", () => {
        if (button.dataset.key === "." && importeRecibidoInput.value.includes(".")) return;
        importeRecibidoInput.value += button.dataset.key;
        calcularDevolucion();
      });
    });

    clearInputBtn.addEventListener("click", () => {
      importeRecibidoInput.value = "";
      importeDevolverInput.value = "";
    });

    /*document.getElementById("payCash").addEventListener("click", () => alert("Pago en efectivo seleccionado."));
    document.getElementById("payCard").addEventListener("click", () => alert("Pago con tarjeta seleccionado."));
    document.getElementById("payOther").addEventListener("click", () => alert("Otro método de pago seleccionado."));*/

    renderProductos();

    function pagar(metodo) {
        if (ventaItems.length === 0) return; //Si no tengo elementos -> me voy

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                
                //OK
                if (this.responseText > 0) {
                    document.getElementById("alert_ok").hidden = false;
                    setTimeout(() => {
                        document.getElementById("alert_ok").hidden = true;
                    }, 3000); // 3000 ms = 3 segundos
                    limpiar();
                    //Actualizamos el link de imprimir
                    var link = document.getElementById("imprimir");
                    link.setAttribute("href", "TpvController.php?print_venta="+this.responseText);
                    link.click();
                }
                //KO
                else {
                    console.log("Error: "+this.responseText);
                    document.getElementById("alert_ko").hidden = false;
                    setTimeout(() => {
                        document.getElementById("alert_ko").hidden = true;
                    }, 3000); // 3000 ms = 3 segundos
                }
            }
        };
        xmlhttp.open("POST", "TpvController.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send("data="+JSON.stringify(ventaItems)+"&metodo="+metodo);
    }

    function limpiar() {
        ventaItems = [];
        actualizarDetalle();
        importeRecibidoInput.value = "";
        importeDevolverInput.value = "";
    }