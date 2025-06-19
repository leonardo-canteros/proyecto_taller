<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="http://localhost/proyecto_taller/assets/css/formuProdu.css">
</head>
    <body>

        <!-- Mostrar el mensaje de éxito o error -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de creación de producto -->
        <form action="<?= base_url('admin/panel/crear') ?>" method="post" enctype="multipart/form-data" class="formuProdu">
        <div class="formuProdu-field">
            <label for="nombre" class="formuProdu-label">Nombre del Producto</label>
            <input type="text" class="formuProdu-input" id="nombre" name="nombre" required>
        </div>
        <div class="formuProdu-field">
            <label for="descripcion" class="formuProdu-label">Descripción</label>
            <textarea class="formuProdu-textarea" id="descripcion" name="descripcion" required></textarea>
        </div>
        <div class="formuProdu-field">
            <label for="precio" class="formuProdu-label">Precio</label>
            <input type="number" class="formuProdu-input" id="precio" name="precio" required>
        </div>
        <div class="formuProdu-field">
            <label for="talla" class="formuProdu-label">Talla</label>
            <input type="text" class="formuProdu-input" id="talla" name="talla" required>
        </div>
        <div class="formuProdu-field">
            <label for="color" class="formuProdu-label">Color</label>
            <input type="text" class="formuProdu-input" id="color" name="color" required>
        </div>
        <div class="formuProdu-field">
            <label for="imagen" class="formuProdu-label">Imagen</label>
            <input type="file" class="formuProdu-file" id="imagen" name="imagen" required>
        </div>
        <div class="formuProdu-field">
            <label for="estado" class="formuProdu-label">Estado</label>
            <select class="formuProdu-select" id="estado" name="estado" required>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>

        <!-- Campo para stock -->
        <div class="formuProdu-field">
            <label for="stock" class="formuProdu-label">Stock</label>
            <input type="number" class="formuProdu-input" id="stock" name="stock" required>
        </div>

        <button type="submit" class="formuProdu-btn">Crear Producto</button>
    </form>


</body>
</html>
