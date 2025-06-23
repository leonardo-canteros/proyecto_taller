<main class="container my-5">
  <h1 class="text-white text-center mb-4">Detalle del Producto</h1>

  <div class="row g-4">
    <div class="col-md-6 text-center">
      <img src="/proyecto_taller/assets/<?= esc($producto['imagen']) ?>"
           alt="<?= esc($producto['nombre']) ?>"
           class="img-fluid rounded shadow border"
           style="max-height: 400px; object-fit: contain;">
    </div>

    <div class="col-md-6">
      <div class="bg-light p-4 rounded shadow-sm h-100">
        <h2 class="mb-3"><?= esc($producto['nombre']) ?></h2>
        <p class="text-muted"><?= esc($producto['descripcion']) ?></p>

        <ul class="list-group list-group-flush mb-3">
          <li class="list-group-item"><strong>Precio:</strong> $<?= number_format($producto['precio'], 2) ?></li>
          <li class="list-group-item"><strong>Talle:</strong> <?= esc($producto['talla']) ?></li>
          <li class="list-group-item"><strong>Color:</strong> <?= esc($producto['color']) ?></li>
          <li class="list-group-item"><strong>Categoría:</strong> <?= esc($producto['categoria']) ?></li>
        </ul>

        <?php if (session()->has('id_usuario')): ?>
          <button class="btn btn-success w-100 btn-comprar"
                  data-producto-id="<?= $producto['id_producto'] ?>">
            <i class="fas fa-cart-plus me-2"></i> Agregar al carrito
          </button>
        <?php else: ?>
          <a href="<?= base_url('login') ?>" class="btn btn-outline-primary w-100">
            <i class="fas fa-sign-in-alt me-2"></i> Inicia sesión para comprar
          </a>
        <?php endif; ?>

        <a href="<?= base_url('catalogo') ?>" class="btn btn-secondary w-100 mt-2">
          <i class="fas fa-arrow-left me-2"></i> Volver al catálogo
        </a>
      </div>
    </div>
  </div>
</main>

<!-- Toast (puedes mejorarlo si ya usás uno en catálogo) -->
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
// Mostrar toast
function showToast(message) {
  const toast = document.getElementById('toast');
  toast.textContent = message;
  toast.style.display = 'block';
  setTimeout(() => {
    toast.style.display = 'none';
  }, 2500);
}

// Lógica para agregar al carrito
document.querySelectorAll('.btn-comprar').forEach(button => {
  button.addEventListener('click', function () {
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
