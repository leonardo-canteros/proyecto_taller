
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
    <label for="exampleInputNombre" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="exampleInputNombre" aria-describedby="nombreHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputAsunto" class="form-label">Asunto</label>
    <input type="text" class="form-control" id="exampleInputAsunto" aria-describedby="asuntoHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputCorreo" class="form-label">Correo</label>
    <input type="email" class="form-control" id="exampleInputCorreo">
  </div>
  <div class="mb-3">
    <label for="exampleInputTexto" class="form-label">Texto</label>
    <input type="text" class="form-control" id="exampleInputTexto" aria-describedby="textoHelp">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Confirmar enviar la Solicitud</label>
  </div>
  <button type="submit" class="btn btn-primary">Enviar</button>
</form>

