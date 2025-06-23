<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos - Costura Fina</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            padding-top: 20px;
            background-color: #f8f9fa;
        }
        .table th {
            border-top: none;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h2 class="mb-4">Mis Pedidos</h2>

        <?php if (empty($pedidos)): ?>
            <div class="alert alert-info">No tienes pedidos realizados</div>
            <a href="<?= base_url('catalogo') ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i> Volver al catálogo
            </a>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>N° Pedido</th>
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
                            <td><?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?></td>
                            <td>$<?= number_format($pedido['Total'], 2) ?></td>
                            <td>
                                <span class="badge bg-<?= 
                                    $pedido['estado_pedido'] == 1 ? 'warning' : 
                                    ($pedido['estado_pedido'] == 2 ? 'success' : 'secondary') 
                                ?>">
                                    <?= $pedido['estado_pedido'] == 1 ? 'Pendiente' : 
                                       ($pedido['estado_pedido'] == 2 ? 'Enviado' : 'Cancelado') ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url("pedidos/ver/{$pedido['id_pedido']}") ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    Ver Detalle
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>