<!-- app/Views/admin/lista_productos.php -->
<div class="container mt-4">
  <!-- Alertas -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <!-- Título -->
  <h1 class="mb-4 text-white">Lista de Productos</h1>

  <!-- Botón para crear nuevo -->
  <a href="<?= site_url('admin/panel') ?>" class="btn btn-success mb-3">
    <i class="fas fa-plus-circle me-1"></i> Nuevo Producto
  </a>

  <!-- Tabla responsiva -->
  <div class="table-responsive">
    <table class="table table-striped table-dark">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Stock</th>
          <th>Categoría</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($productos as $p): ?>
        <tr>
          <td><?= esc($p['id_producto']) ?></td>
          <td><?= esc($p['nombre']) ?></td>
          <td>$<?= number_format($p['precio'], 2) ?></td>
          <td><?= esc($p['stock']) ?></td>
          <td><?= esc($p['categoria']) ?></td>
          <td><?= esc($p['estado']) ?></td>
          <td>
            <a href="<?= site_url('admin/productos/modificar/'.$p['id_producto']) ?>"
               class="btn btn-sm btn-primary">
              <i class="fas fa-edit me-1"></i> Editar
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
