<div class="container mt-5">
    <h2 class="text-center text-white mb-4">Pedidos Realizados</h2>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (!empty($pedidos)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Dirección</th>
                        <th>Método de Pago</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?= esc($pedido['id_pedido']) ?></td>
                            <td><?= esc($pedido['nombre_usuario']) ?></td>
                            <td><?= esc($pedido['fecha_pedido']) ?></td>
                            <td>$<?= number_format($pedido['Total'], 2) ?></td>
                            <td><?= esc($pedido['direccion_envio']) ?></td>
                            <td><?= esc($pedido['metodo_pago']) ?></td>
                            <td>
                                <?php
                                    $estados = [
                                        0 => 'Cancelado',
                                        1 => 'Pendiente',
                                        2 => 'Enviado',
                                        3 => 'Finalizado'
                                    ];
                                    echo $estados[$pedido['estado_pedido']] ?? 'Desconocido';
                                ?>
                            </td>
                            <td>
                                <form method="post" action="<?= base_url('admin/pedidos/cambiarEstado/' . $pedido['id_pedido']) ?>">
                                    <?= csrf_field() ?> <!-- Seguridad CSRF si está habilitada -->
                                    <div class="input-group">
                                        <select name="estado" class="form-select" required>
                                            <option value="0" <?= $pedido['estado_pedido'] == 0 ? 'selected' : '' ?>>Cancelado</option>
                                            <option value="1" <?= $pedido['estado_pedido'] == 1 ? 'selected' : '' ?>>Pendiente</option>
                                            <option value="2" <?= $pedido['estado_pedido'] == 2 ? 'selected' : '' ?>>Enviado</option>
                                            <option value="3" <?= $pedido['estado_pedido'] == 3 ? 'selected' : '' ?>>Finalizado</option>
                                        </select>
                                        <button class="btn btn-sm btn-success" type="submit">Cambiar</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No hay pedidos registrados.</div>
    <?php endif; ?>
</div>
