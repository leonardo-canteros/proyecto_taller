<h1>Crear Producto</h1>
<form action="<?= base_url('productos/crear') ?>" method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <textarea name="descripcion" placeholder="Descripción"></textarea>
    <input type="number" name="precio" step="0.01" placeholder="Precio" required>
    <input type="number" name="stock" placeholder="Stock" required>
    <select name="talla">
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
    </select>
    <input type="text" name="color" placeholder="Color">
    <select name="id_categoria" required>
        <?php foreach ($categorias as $categoria): ?>
        <option value="<?= $categoria['id_categoria'] ?>"><?= $categoria['nombre'] ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Guardar</button>
</form>