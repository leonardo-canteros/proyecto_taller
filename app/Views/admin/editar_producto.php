<h2 class="text-white mb-4">Editar Producto</h2>

<!-- Mostrar errores -->
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger">
    <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>

<form action="<?= site_url('admin/productos/actualizar/' . $producto['id_producto']) ?>"
      method="post"
      enctype="multipart/form-data"
      class="formuProdu">

  <div class="formuProdu-field">
    <label class="formuProdu-label">Nombre</label>
    <input type="text" name="nombre" class="formuProdu-input" required
           value="<?= esc(old('nombre', $producto['nombre'])) ?>">
  </div>

  <div class="formuProdu-field">
    <label class="formuProdu-label">Descripción</label>
    <textarea name="descripcion" class="formuProdu-textarea" required><?= esc(old('descripcion', $producto['descripcion'])) ?></textarea>
  </div>

  <div class="formuProdu-field">
    <label class="formuProdu-label">Precio</label>
    <input type="number" name="precio" class="formuProdu-input" required step="0.01" min="0"
           value="<?= esc(old('precio', $producto['precio'])) ?>">
  </div>

  <div class="formuProdu-field">
    <label class="formuProdu-label">Stock</label>
    <input type="number" name="stock" class="formuProdu-input" required min="0"
           value="<?= esc(old('stock', $producto['stock'])) ?>">
  </div>

  <div class="formuProdu-field">
    <label class="formuProdu-label">Talla</label>
    <input type="text" name="talla" class="formuProdu-input" required
           value="<?= esc(old('talla', $producto['talla'])) ?>">
  </div>

  <div class="formuProdu-field">
    <label class="formuProdu-label">Color</label>
    <input type="text" name="color" class="formuProdu-input" required
           value="<?= esc(old('color', $producto['color'])) ?>">
  </div>

  <div class="formuProdu-field">
    <label class="formuProdu-label">Categoría</label>
    <input type="text" name="categoria" class="formuProdu-input" required
           value="<?= esc(old('categoria', $producto['categoria'])) ?>">
  </div>

  <!-- Imagen actual -->
    <div class="formuProdu-field">
    <label class="formuProdu-label">Imagen Actual</label>
    <div>
        <img
        src="<?= '/proyecto_taller/assets/img/' . basename($producto['imagen']) ?>"
        alt="Imagen de <?= esc($producto['nombre']) ?>"
        style="max-width:200px; display:block; margin-bottom:10px;"
        >
    </div>
    </div>

  <!-- Imagen nueva (opcional) -->
  <div class="formuProdu-field">
    <label class="formuProdu-label">Cambiar Imagen</label>
    <input type="file" name="imagen" class="formuProdu-file">
  </div>

  <div class="formuProdu-field">
    <label class="formuProdu-label">Estado</label>
    <select name="estado" class="formuProdu-select" required>
      <option value="activo" <?= old('estado', $producto['estado']) === 'activo' ? 'selected' : '' ?>>Activo</option>
      <option value="inactivo" <?= old('estado', $producto['estado']) === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
    </select>
  </div>

  <button type="submit" class="formuProdu-btn">Actualizar Producto</button>
</form>
