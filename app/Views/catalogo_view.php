<main class="container my-4">
  <h1 class="mb-4 text-white text-center">Catálogo de Productos</h1>

  <!-- Formulario de filtros -->
  <form method="get" action="<?= site_url('catalogo') ?>" class="row g-3 mb-4">
    <div class="col-md-3">
      <label class="form-label text-white">Categoría</label>
      <select name="categoria" class="form-select">
        <option value="">— Todas —</option>
        <?php foreach ($categorias as $c): ?>
          <option value="<?= esc($c) ?>" <?= ($filtros['categoria'] ?? '') === $c ? 'selected' : '' ?>>
            <?= esc($c) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label text-white">Color</label>
      <select name="color" class="form-select">
        <option value="">— Todos —</option>
        <?php foreach ($colores as $color): ?>
          <option value="<?= esc($color) ?>" <?= ($filtros['color'] ?? '') === $color ? 'selected' : '' ?>>
            <?= esc($color) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-2">
      <label class="form-label text-white">Precio desde</label>
      <input type="number" step="0.01" name="precio_min" class="form-control"
             value="<?= esc($filtros['precio_min'] ?? '') ?>">
    </div>

    <div class="col-md-2">
      <label class="form-label text-white">Precio hasta</label>
      <input type="number" step="0.01" name="precio_max" class="form-control"
             value="<?= esc($filtros['precio_max'] ?? '') ?>">
    </div>

    <div class="col-md-2 d-flex align-items-end">
      <button type="submit" class="btn btn-primary w-100 me-2">Filtrar</button>
      <a href="<?= site_url('catalogo') ?>" class="btn btn-secondary w-100">Limpiar</a>
    </div>
  </form>

  <!-- Resultados -->
  <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
    <?php if (!empty($productos)): ?>
      <?php foreach ($productos as $index => $prod): ?>
        <div class="col">
          <div class="card h-100 shadow-sm fade-in" style="animation-delay: <?= $index * 100 ?>ms">
            <?php
              $imagenPath = !empty($prod['imagen'])
                ? '/proyecto_taller/assets/' . ltrim($prod['imagen'], '/')
                : '/proyecto_taller/assets/img/no-image.jpg';
            ?>
            <img src="<?= esc($imagenPath) ?>" class="card-img-top" alt="<?= esc($prod['nombre']) ?>">

            <div class="card-body">
              <h5 class="card-title"><?= esc($prod['nombre']) ?></h5>
              <p class="card-text text-muted small"><?= esc($prod['descripcion']) ?></p>
              <p class="fw-bold text-success">$<?= number_format($prod['precio'], 2) ?></p>
              <p class="mb-1"><strong>Talle:</strong> <span class="badge bg-secondary"><?= esc($prod['talla']) ?></span></p>
              <p><strong>Color:</strong> <?= esc($prod['color']) ?></p>
            </div>

            <div class="card-footer bg-light">
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
      <?php endforeach; ?>
    <?php else: ?>
      <div style="position: relative; min-height: 30vh; width: 100%;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
          <div class="alert alert-warning text-center px-4 py-3">
            <i class="fas fa-box-open me-2"></i> No se encontraron productos con esos filtros.
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</main>

<!-- Toast de confirmación -->
<div id="toast" style="
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: #198754;
  color: white;
  padding: 15px 20px;
  border-radius: 10px;
  display: none;
  z-index: 9999;
  box-shadow: 0 0 10px rgba(0,0,0,0.3);
">
  Producto agregado al carrito 🛒
</div>

<script>
// Función para mostrar el toast
function showToast(message) {
  const toast = document.getElementById('toast');
  toast.textContent = message;
  toast.style.display = 'block';
  setTimeout(() => {
    toast.style.display = 'none';
  }, 2500);
}

// Agregar al carrito con fetch
document.querySelectorAll('.btn-comprar').forEach(button => {
  button.addEventListener('click', function() {
    const productId = this.getAttribute('data-producto-id');

    fetch('<?= base_url("carrito/agregar") ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({ id_producto: productId, cantidad: 1 })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        showToast('Producto agregado al carrito 🛒');
      } else {
        alert(data.message || 'Error al agregar al carrito.');
      }
    })
    .catch(() => alert('Error de conexión'));
  });
});
</script>
