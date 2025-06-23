<h1>Productos</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Categoría</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($productos as $producto): ?>
    <tr>
        <td><?= $producto['id_producto'] ?></td>
        <td><?= $producto['nombre'] ?></td>
        <td>$<?= number_format($producto['precio'], 2) ?></td>
        <td><?= $producto['stock'] ?></td>
        <td><?= $producto['categoria_nombre'] ?></td>
        <td>
            <a href="<?= base_url('productos/editar/' . $producto['id_producto']) ?>">Editar</a>
            <form action="<?= base_url('productos/eliminar/' . $producto['id_producto']) ?>" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="<?= base_url('productos/crear') ?>">Nuevo Producto</a>