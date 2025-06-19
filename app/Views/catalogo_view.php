<div class="container mt-4">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $prod): ?>
                <div class="col">
                    <div class="card h-100 shadow">
                        <?php
                        $imagenPath = !empty($prod['imagen']) 
                            ? '/proyecto_taller/assets/' . ltrim($prod['imagen'], '/')
                            : '/proyecto_taller/assets/img/no-image.jpg';
                        ?>

                        <img src="<?= esc($imagenPath) ?>" 
                             class="card-img-top p-2" 
                             alt="<?= esc($prod['nombre']) ?>"
                             style="height: 200px; object-fit: contain;">

                        <div class="card-body">
                            <h5 class="card-title"><?= esc($prod['nombre']) ?></h5>
                            <p class="card-text text-muted small">
                                <?= esc($prod['descripcion']) ?>
                            </p>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-success fw-bold">$<?= number_format($prod['precio'], 2) ?></span>
                                <div>
                                    <span class="badge bg-secondary me-1"><?= esc($prod['talla']) ?></span>
                                    <span class="badge bg-info"><?= esc($prod['color']) ?></span>
                                </div>
                            </div>
                            
                            <!-- Botón de compra con verificación de sesión -->
                            <div class="mt-3">
                                <?php if (session()->has('id_usuario')): ?>
                                    <button class="btn btn-primary w-100 btn-comprar" 
                                            data-producto-id="<?= $prod['id_producto'] ?>">
                                        <i class="fas fa-cart-plus me-2"></i> Agregar al carrito
                                    </button>
                                <?php else: ?>
                                    <a href="<?= base_url('login') ?>" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-sign-in-alt me-2"></i> Inicia sesión para comprar
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center py-4">
                    <i class="fas fa-box-open me-2"></i> No hay productos disponibles
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Script para manejar el evento de compra -->
<script>
document.querySelectorAll('.btn-comprar').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-producto-id');
        console.log("ID del producto:", productId); 
        
        fetch('<?= base_url("carrito/agregar") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                id_producto: productId,
                cantidad: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar notificación de éxito
                const toast = new bootstrap.Toast(document.getElementById('cartToast'));
                document.getElementById('toastMessage').textContent = data.message;
                toast.show();
                
                // Actualizar contador del carrito si existe
                if (document.getElementById('cartCount')) {
                    document.getElementById('cartCount').textContent = data.total_items || 0;
                }
            } else {
                alert(data.message || 'Error al agregar al carrito');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        });
    });
});
</script>

<!-- Toast de notificación (agregar en tu layout principal) -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="cartToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Carrito</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastMessage">
            Producto agregado al carrito
        </div>
    </div>
</div>