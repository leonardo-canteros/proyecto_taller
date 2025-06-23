<div class="page-content">
  <div class="container mt-5">
        <h2 class="mb-4 text-white text-center"><?= esc($title) ?></h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (empty($consultas)): ?>
            <div class="alert alert-info">No hay consultas registradas.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-dark table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Usuario</th>
                            <th>Asunto</th>
                            <th>Mensaje</th>
                            <th>Estado</th>
                            <th>Respuesta</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consultas as $c): ?>
                            <tr>
                                <td><?= esc($c['nombre_usuario'] . ' ' . $c['apellido_usuario']) ?></td>
                                <td><?= esc($c['asunto']) ?></td>
                                <td><?= esc($c['mensaje']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $c['estado'] === 'respondido' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($c['estado']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $c['respuesta'] ? esc($c['respuesta']) : '<em>No respondida</em>' ?>
                                </td>
                                <td>
                                    <?php if ($c['estado'] !== 'respondido'): ?>
                                        <a href="<?= site_url('admin/consultas/' . $c['id_consulta']) ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-reply"></i> Responder
                                        </a>
                                    <?php else: ?>
                                        <span class="text-success">Respondida</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>