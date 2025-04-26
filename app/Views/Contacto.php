
    <script>
        // Función para manejar el envío del formulario
        function handleSubmit(event) {
            // Evitar que el formulario se envíe de la manera tradicional
            event.preventDefault();

            // Mostrar el alert con el mensaje
            alert("Solicitud enviada");

            // Limpiar los campos del formulario después de cerrar el alert
            document.getElementById("contactForm").reset();
        }
    </script>

<form id="contactForm" onsubmit="handleSubmit(event)">
  <div class="mb-3">
    <label for="exampleInputNombre" class="form-label">Nombre*</label>
    <input type="text" class="form-control" aria-describedby="nombreHelp" required>
    <div id="nombreError" class="invalid-feedback">Por favor ingresa tu nombre</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputAsunto" class="form-label">Asunto*</label>
    <input type="text" class="form-control"aria-describedby="asuntoHelp" required>
    <div id="asuntoError" class="invalid-feedback">Por favor ingresa el asunto</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputCorreo" class="form-label">Correo*</label>
    <input type="email" class="form-control"required>
    <div id="correoError" class="invalid-feedback">Por favor ingresa un correo válido</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputTexto" class="form-label">Texto*</label>
    <textarea class="form-control"rows="3" required></textarea>
    <div id="textoError" class="invalid-feedback">Por favor ingresa tu mensaje</div>
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
    <label class="form-check-label" for="exampleCheck1">Confirmar enviar la Solicitud*</label>
    <div id="checkError" class="invalid-feedback">Debes confirmar el envío</div>
  </div>
  <button type="submit" class="btn btn-primary">Enviar</button>
</form>

