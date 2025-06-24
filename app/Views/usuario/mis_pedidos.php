<div class="container mt-4">
    <h2 class="text-center text-white mb-4">Mis pedidos</h2>

    <?php if (!empty($pedidos)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Dirección</th>
                        <th>Método de Pago</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?= esc($pedido['id_pedido']) ?></td>
                            <td><?= esc(date('d/m/Y H:i', strtotime($pedido['fecha_pedido']))) ?></td>
                            <td>$<?= number_format($pedido['Total'], 2) ?></td>
                            <td><?= esc($pedido['direccion_envio']) ?></td>
                            <td><?= esc($pedido['metodo_pago']) ?></td>
                            <td>
                                <span class="badge bg-<?= 
                                    $pedido['estado_pedido'] == 2 ? 'success' : 
                                    ($pedido['estado_pedido'] == 1 ? 'warning' : 'secondary') ?>">
                                    <?= 
                                        $pedido['estado_pedido'] == 2 ? 'Finalizado' :
                                        ($pedido['estado_pedido'] == 1 ? 'Pendiente' : 'Cancelado') ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No se encontraron pedidos.</div>
    <?php endif; ?>
</div>
