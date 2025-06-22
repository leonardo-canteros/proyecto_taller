<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración</title>
</head>
<body>

  <!-- Mensajes de éxito o error -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php elseif (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <!-- Formulario -->
  <form action="<?= base_url('admin/panel/crear') ?>" method="post" enctype="multipart/form-data" class="formuProdu">

    <div class="formuProdu-field">
      <label for="nombre" class="formuProdu-label">Nombre del Producto</label>
      <input type="text" class="formuProdu-input" id="nombre" name="nombre" required value="<?= esc(old('nombre')) ?>">
    </div>

    <div class="formuProdu-field">
      <label for="descripcion" class="formuProdu-label">Descripción</label>
      <textarea class="formuProdu-textarea" id="descripcion" name="descripcion" required><?= esc(old('descripcion')) ?></textarea>
    </div>

    <div class="formuProdu-field">
      <label for="precio" class="formuProdu-label">Precio</label>
      <input type="number" class="formuProdu-input" id="precio" name="precio" required step="0.01" min="0" value="<?= esc(old('precio')) ?>">
    </div>

    <div class="formuProdu-field">
      <label for="talla" class="formuProdu-label">Talla</label>
      <input type="text" class="formuProdu-input" id="talla" name="talla" required value="<?= esc(old('talla')) ?>">
    </div>

    <div class="formuProdu-field">
      <label for="color" class="formuProdu-label">Color</label>
      <input type="text" class="formuProdu-input" id="color" name="color" required value="<?= esc(old('color')) ?>">
    </div>

    <div class="formuProdu-field">
      <label for="imagen" class="formuProdu-label">Imagen</label>
      <input type="file" class="formuProdu-file" id="imagen" name="imagen" required>
    </div>

    <div class="formuProdu-field">
      <label for="estado" class="formuProdu-label">Estado</label>
      <select class="formuProdu-select" id="estado" name="estado" required>
        <option value="activo" <?= old('estado') === 'activo' ? 'selected' : '' ?>>Activo</option>
        <option value="inactivo" <?= old('estado') === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
      </select>
    </div>

    <div class="formuProdu-field">
      <label for="stock" class="formuProdu-label">Stock</label>
      <input type="number" class="formuProdu-input" id="stock" name="stock" required min="0" value="<?= esc(old('stock')) ?>">
    </div>

    <div class="formuProdu-field">
      <label for="categoria" class="formuProdu-label">Categoría</label>
      <input type="text" class="formuProdu-input" id="categoria" name="categoria" required value="<?= esc(old('categoria')) ?>">
    </div>

    <button type="submit" class="formuProdu-btn">Crear Producto</button>
  </form>

</body>
</html>
