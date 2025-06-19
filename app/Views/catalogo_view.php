<div class="container mt-4">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $prod): ?>
                <div class="col">
                    <div class="card h-100 shadow">
                        <?php
                        // Defino la ruta de la imagen correcta sin usar base_url()
                        $imagenPath = !empty($prod['imagen']) 
                            ? 'http://' . $_SERVER['HTTP_HOST'] . '/proyecto_taller/assets/' . ltrim($prod['imagen'], '/')
                            : 'http://' . $_SERVER['HTTP_HOST'] . '/proyecto_taller/assets/img/no-image.jpg';
                        ?>

                        <!-- Mostrar la imagen del producto -->
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
