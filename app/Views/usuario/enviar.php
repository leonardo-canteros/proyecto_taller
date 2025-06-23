<main class="container my-5">
  <h1 class="text-center text-white mb-4"><?= esc($title) ?></h1>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>

  <form action="<?= site_url('usuario/consultas') ?>" method="post" class="bg-light p-4 rounded shadow">
    <?= csrf_field() ?>

    <div class="mb-3">
      <label for="asunto" class="form-label">Asunto</label>
      <input type="text" class="form-control" id="asunto" name="asunto" required>
    </div>

    <div class="mb-3">
      <label for="mensaje" class="form-label">Mensaje</label>
      <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Enviar Consulta</button>
  </form>
</main>
