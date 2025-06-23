
    <div class="container py-5">
        <h1 class="mb-4"><?= esc($titulo ?? 'Mi Carrito de Compras') ?></h1>
        
        <?php if (empty($productos)): ?>
            <div class="alert alert-info">
                <i class="fas fa-shopping-cart me-2"></i> Tu carrito está vacío
            </div>
            <a href="<?= base_url('catalogo') ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i> Continuar comprando
            </a>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 80px;"></th>
                                            <th>Producto</th>
                                            <th class="text-end">Precio</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-end">Subtotal</th>
                                            <th style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($productos as $producto): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($producto['imagen'])): ?>
                                                    <img src="<?= base_url('assets' . $producto['imagen']) ?>" alt="<?= esc($producto['nombre']) ?>" class="img-thumbnail">
                                                <?php else: ?>
                                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <h6 class="mb-1"><?= esc($producto['nombre']) ?></h6>
                                                <?php if (isset($producto['stock'])): ?>
                                                    <small class="text-muted">Stock: <?= $producto['stock'] ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end align-middle">
                                                $<?= number_format($producto['precio'], 2) ?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <form action="<?= base_url('carrito/actualizar/' . $producto['id_carrito']) ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" name="cantidad" value="<?= $producto['cantidad'] ?>" min="1" max="<?= $producto['stock'] ?? 99 ?>" class="form-control quantity-input">
                                                        <button type="submit" class="btn btn-outline-secondary" title="Actualizar">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-end align-middle">
                                                $<?= number_format($producto['precio'] * $producto['cantidad'], 2) ?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <form action="<?= base_url('carrito/eliminar/' . $producto['id_carrito']) ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-link text-danger" title="Eliminar" onclick="return confirm('¿Eliminar este producto del carrito?')">
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
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i> Seguir comprando
                                </a>
                                <form action="<?= base_url('carrito/vaciar/' . session()->get('id_usuario')) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Vaciar completamente el carrito?')">
                                        <i class="fas fa-trash-alt me-2"></i> Vaciar carrito
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Resumen del Pedido</h5>
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
                             <form action="<?= base_url('pedidos/finalizar-compra') ?>" method="post" id="formPago">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección de envío</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="direccion" name="direccion" 
                                            value="<?= esc(session()->get('direccion') ?? '') ?>" required>
                                        <button class="btn btn-outline-secondary" type="button" id="btn-usar-perfil">
                                            <i class="fas fa-user"></i> Usar de mi perfil
                                        </button>
                                    </div>
                                    <small class="text-muted">Puedes modificarla si es diferente a la de tu perfil</small>
                                </div>
                                <div class="mb-3">
                                    <label for="metodo_pago" class="form-label">Método de pago</label>
                                    <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                        <option value="">Seleccione un método</option>
                                        <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                                        <option value="Transferencia bancaria">Transferencia bancaria</option>
                                        <option value="Efectivo">Efectivo</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    <i class="fas fa-credit-card me-2"></i> Confirmar pedido
                                </button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Actualización de cantidad con feedback
        $('form[action^="/carrito/actualizar/"]').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var button = form.find('button[type="submit"]');
            
            button.html('<i class="fas fa-spinner fa-spin"></i>');
            button.prop('disabled', true);
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                        button.html('<i class="fas fa-check"></i>');
                        button.prop('disabled', false);
                    }
                },
                error: function() {
                    alert('Error al actualizar la cantidad');
                    button.html('<i class="fas fa-check"></i>');
                    button.prop('disabled', false);
                }
            });
        });

        // Confirmación antes de eliminar
        $('form[action^="/carrito/eliminar/"]').on('submit', function() {
            return confirm('¿Estás seguro de eliminar este producto del carrito?');
        });
    });

    
    // Obtener dirección del usuario desde la sesión
    const direccionUsuario = "<?= esc(session()->get('direccion') ?? '') ?>";

    // Botón para restaurar la dirección del perfil
    $('#btn-usar-perfil').on('click', function() {
        if (direccionUsuario) {
            $('#direccion').val(direccionUsuario);
            $(this).html('<i class="fas fa-check"></i> Usada');
            setTimeout(() => {
                $(this).html('<i class="fas fa-user"></i> Usar de mi perfil');
            }, 2000);
        } else {
            alert('No tienes una dirección guardada en tu perfil');
        }
    });

    // Validar formulario antes de enviar
    $('#formPago').on('submit', function(e) {
        e.preventDefault();
        
        // Validaciones básicas
        if ($('#direccion').val().trim() === '') {
            alert('Por favor ingresa una dirección de envío');
            return;
        }
        
        if ($('#metodo_pago').val() === '') {
            alert('Por favor selecciona un método de pago');
            return;
        }

        const boton = $(this).find('button[type="submit"]');
        const textoOriginal = boton.html();
        boton.html('<i class="fas fa-spinner fa-spin me-2"></i> Procesando...');
        boton.prop('disabled', true);
        
        // Agregar CSRF token manualmente
        const formData = $(this).serialize() + '&<?= csrf_token() ?>=<?= csrf_hash() ?>';
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = "<?= base_url('catalogo') ?>";
                } else {
                    alert(response.message || 'Error al procesar el pedido');
                    boton.html(textoOriginal);
                    boton.prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error detallado:', status, error);
                alert('Error de conexión. Detalles en consola (F12)');
                boton.html(textoOriginal);
                boton.prop('disabled', false);
            }
        });
    });

    // Validación en tiempo real
    $('#direccion, #metodo_pago').on('input change', function() {
        const formValid = $('#direccion').val().trim() !== '' && $('#metodo_pago').val() !== '';
        $('#formPago button[type="submit"]').prop('disabled', !formValid);
    });

    </script>
