<div class="container-fluid px-4">
    <h1 class="text-center mb-5 text-white fw-bold">Mi Carrito de Compras</h1>

    <?php if (empty($productos)): ?>
        <div class="alert alert-info text-center">No hay productos en el carrito.</div>
    <?php else: ?>
        <div class="row justify-content-center">
            <!-- Lista de productos -->
            <div class="col-lg-7 mb-4">
                <div class="card shadow w-100" style="min-height: 100%;">
                    <div class="card-header bg-dark text-white fw-bold">
                        Productos en el carrito
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Producto</th>
                                        <th class="text-end">Precio</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-end">Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($productos as $p): ?>
                                    <tr>
                                        <td style="width: 80px;">
                                            <img src="/assets/img/<?= esc(basename($p['imagen'])) ?>" alt="imagen" class="img-thumbnail" style="max-width: 70px;">
                                        </td>
                                        <td>
                                            <strong><?= esc($p['nombre']) ?></strong><br>
                                            <small class="text-muted">Stock: <?= $p['stock'] ?? 'N/A' ?></small>
                                        </td>
                                        <td class="text-end">$<?= number_format($p['precio'], 2) ?></td>
                                        <td class="text-center">
                                            <form action="/carrito/actualizar/<?= $p['id_carrito'] ?>" method="post">
                                                <?= csrf_field() ?>
                                                <input type="number" name="cantidad" value="<?= $p['cantidad'] ?>" min="1" max="<?= $p['stock'] ?? 99 ?>" class="form-control form-control-sm" style="width: 70px;">
                                            </form>
                                        </td>
                                        <td class="text-end">$<?= number_format($p['precio'] * $p['cantidad'], 2) ?></td>
                                        <td class="text-end">
                                            <form action="/carrito/eliminar/<?= $p['id_carrito'] ?>" method="post" onsubmit="return confirm('¿Eliminar este producto?')">
                                                <?= csrf_field() ?>
                                                <button class="btn btn-sm btn-link text-danger" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="/catalogo" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i> Seguir comprando
                        </a>
                        <form action="/carrito/vaciar/<?= session()->get('id_usuario') ?>" method="post" onsubmit="return confirm('¿Vaciar el carrito?')">
                            <?= csrf_field() ?>
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-trash-alt me-2"></i> Vaciar carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Resumen -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow" style="min-height: 100%;">
                    <div class="card-header bg-primary text-white fw-bold">
                        Resumen del Pedido
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>$<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Envío:</span>
                            <span class="text-success">Gratis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total:</span>
                            <span>$<?= number_format($total, 2) ?></span>
                        </div>
                        <hr>
                        <form action="/pedidos/finalizar-compra" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección de envío</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" required value="<?= esc(session()->get('direccion') ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label for="metodo_pago" class="form-label">Método de pago</label>
                                <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Efectivo">Efectivo</option>
                                </select>
                            </div>
                            <button class="btn btn-primary w-100">
                                <i class="fas fa-credit-card me-2"></i> Confirmar pedido
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
