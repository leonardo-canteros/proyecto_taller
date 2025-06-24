<div class="container mt-4">
    <h2 class="text-center text-white mb-4">Mis pedidos</h2>

    <?php if (!empty($pedidos)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Dirección</th>
                        <th>Método de Pago</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?= esc($pedido['id_pedido']) ?></td>
                            <td><?= esc(date('d/m/Y H:i', strtotime($pedido['fecha_pedido']))) ?></td>
                            <td>$<?= number_format($pedido['Total'], 2) ?></td>
                            <td><?= esc($pedido['direccion_envio']) ?></td>
                            <td><?= esc($pedido['metodo_pago']) ?></td>
                            <td>
                                <?php
                                    $estados = [
                                        0 => ['label' => 'Cancelado',  'class' => 'secondary'],
                                        1 => ['label' => 'Pendiente',  'class' => 'warning'],
                                        2 => ['label' => 'Enviado',    'class' => 'info'],
                                        3 => ['label' => 'Finalizado', 'class' => 'success'],
                                    ];

                                    $estado = $pedido['estado_pedido'];
                                    $label = $estados[$estado]['label'] ?? 'Desconocido';
                                    $class = $estados[$estado]['class'] ?? 'dark';
                                ?>
                                <span class="badge bg-<?= $class ?>"><?= $label ?></span>
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
