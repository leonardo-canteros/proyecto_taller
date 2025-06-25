<div class="container mt-4 mb-5">
  <h1 class="mb-4 text-white text-center"><?= esc($title) ?></h1>

  <!-- FORMULARIO FILTROS -->
  <form method="get" action="<?= site_url('admin/catalogo') ?>" 
        class="row g-3 mb-5 justify-content-center"
        style="max-width: 900px; margin: 0 auto;">

    <div class="col-12 col-sm-6">
      <label class="form-label text-white">Categoría</label>
      <select name="categoria" class="form-select">
        <option value="">— Todas —</option>
        <?php foreach($categorias as $c): ?>
          <option value="<?= esc($c) ?>" <?= $filtros['cat'] === $c ? 'selected' : '' ?>>
            <?= esc($c) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-12 col-sm-6">
      <label class="form-label text-white">Color</label>
      <select name="color" class="form-select">
        <option value="">— Todos —</option>
        <?php foreach($colores as $color): ?>
          <option value="<?= esc($color) ?>" <?= $filtros['color'] === $color ? 'selected' : '' ?>>
            <?= esc($color) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-12 col-sm-6">
      <label class="form-label text-white">Precio desde</label>
      <input type="number" step="0.01" name="precio_min" class="form-control"
             value="<?= esc($filtros['precio_min']) ?>">
    </div>

    <div class="col-12 col-sm-6">
      <label class="form-label text-white">Precio hasta</label>
      <input type="number" step="0.01" name="precio_max" class="form-control"
             value="<?= esc($filtros['precio_max']) ?>">
    </div>

    <div class="col-6 col-sm-4 d-grid">
      <button type="submit" class="btn btn-primary w-100">Filtrar</button>
    </div>

    <div class="col-6 col-sm-4 d-grid">
      <a href="<?= site_url('admin/catalogo') ?>" class="btn btn-secondary w-100">Limpiar</a>
    </div>
  </form>

  <!-- LISTA DE PRODUCTOS -->
  <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4 mb-5">
    <?php if ($productos): foreach($productos as $i => $prod): ?>
      <div class="col">
        <div class="card h-100 shadow-sm fade-in" style="animation-delay: <?= $i * 100 ?>ms">
          <?php
            $img = !empty($prod['imagen'])
                 ? '/proyecto_taller/assets/' . ltrim($prod['imagen'],'/')
                 : '/proyecto_taller/assets/img/no-image.jpg';
          ?>
          <img src="<?= esc($img) ?>" class="card-img-top p-2"
               style="height:200px; object-fit:contain;" alt="<?= esc($prod['nombre']) ?>">

          <div class="card-body">
            <h5 class="card-title"><?= esc($prod['nombre']) ?></h5>
            <p class="card-text text-muted small"><?= esc($prod['descripcion']) ?></p>
          </div>

          <div class="card-footer bg-light">
            <div class="mb-2">
              <span class="text-success fw-bold">$<?= number_format($prod['precio'],2) ?></span>
            </div>
            <a href="<?= base_url('producto/' . $prod['id_producto']) ?>" class="btn btn-outline-secondary w-100 mb-2">
              <i class="fas fa-eye me-1"></i> Ver más
            </a>
            <a href="<?= site_url('admin/productos/modificar/' . $prod['id_producto']) ?>" class="btn btn-info w-100">
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

<script>
  // Animación fade-in por tarjeta
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.card.fade-in').forEach((card, i) => {
      card.style.opacity = '0';
      card.style.animation = 'fadeInUp 0.5s ease forwards';
      card.style.animationDelay = `${i * 100}ms`;
    });
  });
</script>
