<h1>Editar Producto</h1>
<form action="<?= base_url('productos/editar/' . $producto['id_producto']) ?>" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <input type="text" name="nombre" value="<?= $producto['nombre'] ?>" required>
    <textarea name="descripcion"><?= $producto['descripcion'] ?></textarea>
    <input type="number" name="precio" step="0.01" value="<?= $producto['precio'] ?>" required>
    <input type="number" name="stock" value="<?= $producto['stock'] ?>" required>
    <select name="talla">
        <option value="S" <?= $producto['talla'] == 'S' ? 'selected' : '' ?>>S</option>
        <option value="M" <?= $producto['talla'] == 'M' ? 'selected' : '' ?>>M</option>
        <option value="L" <?= $producto['talla'] == 'L' ? 'selected' : '' ?>>L</option>
        <option value="XL" <?= $producto['talla'] == 'XL' ? 'selected' : '' ?>>XL</option>
    </select>
    <input type="text" name="color" value="<?= $producto['color'] ?>">
    <select name="id_categoria" required>
        <?php foreach ($categorias as $categoria): ?>
        <option value="<?= $categoria['id_categoria'] ?>" 
                <?= $categoria['id_categoria'] == $producto['id_categoria'] ? 'selected' : '' ?>>
            <?= $categoria['nombre'] ?>
        </option>
        <?php endforeach; ?>
    </select>
    <select name="estado">
        <option value="activo" <?= $producto['estado'] == 'activo' ? 'selected' : '' ?>>Activo</option>
        <option value="descontinuado" <?= $producto['estado'] == 'descontinuado' ? 'selected' : '' ?>>Descontinuado</option>
    </select>
    <button type="submit">Actualizar</button>
</form>