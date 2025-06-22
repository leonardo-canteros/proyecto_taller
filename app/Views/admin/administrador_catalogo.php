<div class="container mt-4">
  <h1 class="mb-4 text-white text-center"><?= esc($title) ?></h1>

  <!-- Formulario de filtros -->
  <form method="get" action="<?= site_url('admin/catalogo') ?>" class="row g-3 mb-4">
    <div class="col-md-4">
      <label for="categoria" class="form-label text-white">Categoría</label>
      <select name="categoria" id="categoria" class="form-select">
        <option value="">— Todas —</option>
        <?php foreach($categorias as $c): ?>
        <option value="<?= esc($c) ?>" <?= $filtros['cat'] === $c ? 'selected' : '' ?>>
          <?= esc($c) ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label text-white">Precio desde</label>
      <input type="number" step="0.01" name="precio_min" class="form-control"
             value="<?= esc($filtros['min']) ?>">
    </div>

    <div class="col-md-3">
      <label class="form-label text-white">Precio hasta</label>
      <input type="number" step="0.01" name="precio_max" class="form-control"
             value="<?= esc($filtros['max']) ?>">
    </div>

    <div class="col-md-2 d-grid">
      <button class="btn btn-primary mt-4">Filtrar</button>
    </div>
  </form>

  <!-- Lista de productos -->
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php if ($productos): foreach($productos as $i => $prod): ?>
      <div class="col">
        <div class="card h-100 shadow-sm fade-in" style="animation-delay: <?= $i * 100 ?>ms">
          <?php
            $img = !empty($prod['imagen'])
                 ? '/proyecto_taller/assets/' . ltrim($prod['imagen'],'/')
                 : '/proyecto_taller/assets/img/no-image.jpg';
          ?>
          <img src="<?= esc($img) ?>"
               class="card-img-top p-2"
               style="height:200px; object-fit:contain;"
               alt="<?= esc($prod['nombre']) ?>">

          <div class="card-body">
            <h5 class="card-title"><?= esc($prod['nombre']) ?></h5>
            <p class="card-text text-muted small"><?= esc($prod['descripcion']) ?></p>
          </div>

          <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-success fw-bold">$<?= number_format($prod['precio'],2) ?></span>
            </div>
            <a href="<?= site_url('admin/productos/modificar/' . $prod['id_producto']) ?>"
               class="btn btn-info w-100">
              <i class="fas fa-edit me-1"></i> Editar
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; else: ?>
      <div class="col-12">
        <div class="alert alert-warning text-center">
          <i class="fas fa-exclamation-triangle me-2"></i> No hay productos disponibles
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Opcional: toast para confirmaciones -->
<!--
<div id="toast" style="display: none;
  position: fixed; bottom: 20px; right: 20px;
  background: #17a2b8; color: white;
  padding: 15px 20px; border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.3);
  z-index: 9999;">
  Acción realizada correctamente
</div>
-->

<script>
// Animación escalonada para admin
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.card.fade-in').forEach((card, i) => {
    card.style.opacity = '0';
    card.style.animation = 'fadeInUp 0.5s ease forwards';
    card.style.animationDelay = `${i * 100}ms`;
  });
});
</script>
