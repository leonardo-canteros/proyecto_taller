<div class="container mt-5">
    <h2 class="text-white text-center mb-4">Responder Consulta</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card text-white bg-dark mb-4">
        <div class="card-body">
            <h5 class="card-title">Asunto: <?= esc($consulta['asunto']) ?></h5>
            <p class="card-text">Mensaje: <?= esc($consulta['mensaje']) ?></p>
            <p class="card-text"><small class="text-muted">De: <?= esc($consulta['nombre_usuario']) ?> <?= esc($consulta['apellido_usuario']) ?></small></p>
        </div>
    </div>

    <form action="<?= site_url('admin/consultas/responder/' . $consulta['id_consulta']) ?>" method="post">
        <div class="mb-3">
            <label for="respuesta" class="form-label text-white">Respuesta</label>
            <textarea class="form-control" id="respuesta" name="respuesta" rows="5" required><?= old('respuesta') ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Enviar Respuesta</button>
        <a href="<?= site_url('admin/consultas') ?>" class="btn btn-secondary ms-2">Volver</a>
    </form>
</div>
