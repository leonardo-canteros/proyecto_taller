<main class="container my-5">
  <h1 class="mb-4 text-center text-white">Contactos recibidos</h1>

  <?php if (!empty($contactos)): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Asunto</th>
            <th>Mensaje</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($contactos as $c): ?>
            <tr>
              <td><?= esc($c['id_contacto']) ?></td>
              <td><?= esc($c['nombre']) ?></td>
              <td><?= esc($c['correo']) ?></td>
              <td><?= esc($c['asunto']) ?></td>
              <td><?= esc($c['mensaje']) ?></td>
              <td><?= esc($c['created_at']) ?></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p>No hay consultas registradas.</p>
  <?php endif ?>
</main>
