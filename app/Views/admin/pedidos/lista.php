<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <h2 class="mb-4">Gestión de Pedidos</h2>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>N° Pedido</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td>#<?= $pedido['id_pedido'] ?></td>
                            <td><?= esc($pedido['nombre_usuario']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?></td>
                            <td>$<?= number_format($pedido['Total'], 2) ?></td>
                            <td>
                                <form action="<?= base_url("admin/pedidos/cambiar-estado/{$pedido['id_pedido']}") ?>" method="post">
                                    <select name="estado" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="0" <?= $pedido['estado_pedido'] == 0 ? 'selected' : '' ?>>Cancelado</option>
                                        <option value="1" <?= $pedido['estado_pedido'] == 1 ? 'selected' : '' ?>>Pendiente</option>
                                        <option value="2" <?= $pedido['estado_pedido'] == 2 ? 'selected' : '' ?>>Enviado</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="<?= base_url("admin/pedidos/ver/{$pedido['id_pedido']}") ?>" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>