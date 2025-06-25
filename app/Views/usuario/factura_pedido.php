

<div class="container mt-5 mb-5 bg-white p-4 rounded shadow-sm">
    <h2 class="text-center mb-4">Detalle del Pedido #<?= esc($pedido['id_pedido']) ?></h2>
    
    <?php
        $estados = [
            0 => ['label' => 'Cancelado',  'class' => 'secondary'],
            1 => ['label' => 'Pendiente',  'class' => 'warning'],
            2 => ['label' => 'Enviado',    'class' => 'info'],
            3 => ['label' => 'Finalizado', 'class' => 'success'],
        ];
        $estado = $pedido['estado_pedido'];
        $label  = $estados[$estado]['label'] ?? 'Desconocido';
        $class  = $estados[$estado]['class'] ?? 'dark';
    ?>
     <p><strong>Estado del pedido:</strong>
        <span class="badge bg-<?= $class ?>"><?= $label ?></span>
    </p>
    <p><strong>Fecha:</strong> <?= esc(date('d/m/Y H:i', strtotime($pedido['fecha_pedido']))) ?></p>
    <p><strong>País:</strong> <?= esc($pedido['pais']) ?></p>
    <p><strong>Provincia:</strong> <?= esc($pedido['provincia']) ?></p>
    <p><strong>Localidad:</strong> <?= esc($pedido['region']) ?></p>
    <p><strong>Dirección:</strong> <?= esc($pedido['direccion_envio']) ?></p>
    <p><strong>Método de pago:</strong> <?= esc($pedido['metodo_pago']) ?></p>

    
   
    <hr>

    <h4>Detalle de productos</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $d): ?>
                    <tr>
                        <td><?= esc($d['nombre_producto']) ?></td>
                        <td><?= esc($d['cantidad']) ?></td>
                        <td>$<?= number_format($d['precio_unitario'], 2) ?></td>
                        <td>$<?= number_format($d['cantidad'] * $d['precio_unitario'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th>$<?= number_format($pedido['Total'], 2) ?></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="no-print">
        <a href="<?= site_url('usuario/pedidos') ?>" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Volver a mis pedidos
        </a>

        <a href="<?= site_url('usuario/factura-pdf/' . $pedido['id_pedido']) ?>" class="btn btn-success mt-3 ms-2">
            <i class="fas fa-file-pdf me-1"></i> Descargar PDF
        </a>
    </div>
</div>


