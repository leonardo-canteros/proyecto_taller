<main class="container my-5 d-flex justify-content-center">
  <div class="col-md-6 col-lg-5 col-xl-4">
    <h1 class="text-white text-center mb-4">Formulario de Contacto</h1>

    <!-- Alerta si existe mensaje de éxito -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= esc(session()->getFlashdata('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    <?php endif; ?>

    <!-- Formulario -->
    <form action="<?= site_url('Contacto') ?>" method="post" class="bg-light p-4 rounded shadow-sm">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre *</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>

      <div class="mb-3">
        <label for="asunto" class="form-label">Asunto *</label>
        <input type="text" class="form-control" id="asunto" name="asunto" required>
      </div>

      <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico *</label>
        <input type="email" class="form-control" id="correo" name="correo" required>
      </div>

      <div class="mb-3">
        <label for="mensaje" class="form-label">Mensaje *</label>
        <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="confirmar" id="confirmar" required>
        <label class="form-check-label" for="confirmar">
          Confirmo que deseo enviar esta solicitud *
        </label>
      </div>

      <button type="submit" class="btn btn-primary w-100">
        Enviar mensaje
      </button>
    </form>
  </div>
</main>
