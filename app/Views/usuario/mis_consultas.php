<main class="container my-5">
  <h1 class="text-center text-white mb-4">Mis Consultas</h1>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <?php if (!empty($consultas)): ?>
    <div class="table-responsive-sm">
            <table class="table table-dark table-hover table-bordered align-middle text-center">
              <thead class="align-middle">
                <tr>
                  <th style="min-width: 120px;">Asunto</th>
                  <th style="min-width: 200px;">Mensaje</th>
                  <th style="min-width: 100px;">Estado</th>
                  <th style="min-width: 200px;">Respuesta</th>
                  <th style="min-width: 150px;">Fecha</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($consultas as $c): ?>
                  <tr>
                    <td class="text-truncate" style="max-width: 150px;"><?= esc($c['asunto']) ?></td>
                    <td class="text-truncate" style="max-width: 250px;"><?= esc($c['mensaje']) ?></td>
                    <td>
                      <span class="badge bg-<?= $c['estado'] === 'respondido' ? 'success' : 'warning' ?>">
                        <?= ucfirst($c['estado']) ?>
                      </span>
                    </td>
                    <td class="text-truncate" style="max-width: 250px;"><?= esc($c['respuesta'] ?? '—') ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

  <?php else: ?>
    <div class="alert alert-info text-center">
      Aún no has enviado ninguna consulta.
    </div>
  <?php endif; ?>
</main>
