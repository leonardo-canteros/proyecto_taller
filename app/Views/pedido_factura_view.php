<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Factura del Pedido #<?= esc($pedido['id_pedido']) ?></h4>
        </div>
        <div class="card-body">
            <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?></p>
            <p><strong>Dirección:</strong> <?= esc($pedido['direccion_envio']) ?></p>
            <p><strong>Método de Pago:</strong> <?= esc($pedido['metodo_pago']) ?></p>

            <hr>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Producto</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detalles as $d): ?>
                        <tr class="text-center">
                            <td><?= esc($d['nombre']) ?></td>
                            <td>$<?= number_format($d['precio_unitario'], 2) ?></td>
                            <td><?= esc($d['cantidad']) ?></td>
                            <td>$<?= number_format($d['cantidad'] * $d['precio_unitario'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="text-end fw-bold">
                            <td colspan="3">Total:</td>
                            <td>$<?= number_format($pedido['Total'], 2) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="<?= site_url('usuario/pedidos') ?>" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i> Volver a mis pedidos
            </a>
        </div>
    </div>
</div>
