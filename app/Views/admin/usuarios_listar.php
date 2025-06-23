<main class="container my-5">
  <h1 class="text-white text-center mb-4">Lista de Usuarios</h1>

  <?php if (!empty($usuarios)): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($usuarios as $u): ?>
            <tr>
              <td><?= esc($u['id_usuario']) ?></td>
              <td><?= esc($u['nombre']) ?> <?= esc($u['apellido']) ?></td>
              <td><?= esc($u['correo']) ?></td>
              <td><?= esc($u['telefono']) ?></td>
              <td><?= esc($u['rol']) ?></td>
              <td>
                <?= is_null($u['deleted_at']) ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>' ?>
              </td>
              <td>
                <?php if (is_null($u['deleted_at'])): ?>
                  <form action="<?= site_url('usuarios/desactivar/' . $u['id_usuario']) ?>" method="post" class="d-inline">
                    <button type="submit" class="btn btn-sm btn-danger">Desactivar</button>
                  </form>
                <?php else: ?>
                  <form action="<?= site_url('usuarios/restaurar/' . $u['id_usuario']) ?>" method="post" class="d-inline">
                    <button type="submit" class="btn btn-sm btn-success">Restaurar</button>
                  </form>
                <?php endif ?>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p>No hay usuarios registrados.</p>
  <?php endif ?>
</main>
