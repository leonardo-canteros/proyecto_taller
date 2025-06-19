<link rel="stylesheet" href="/assets/css/formuProdu.css">

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
     <button type="submit" class="formuProdu-btn">Crear Producto</button>
</form>
