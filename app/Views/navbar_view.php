<?php
$session    = session();
$loggedIn   = $session->get('logged_in');
$rol        = $session->get('rol');
$isAdmin    = ($loggedIn && $rol === 'administrador');
$currentUrl = current_url();

// Obtener cantidad TOTAL de productos en el carrito (sumando cantidades)
$cartCount = 0;
$userId = null;
if ($loggedIn) {
    $userId = $session->get('id_usuario');
    $carritoModel = new \App\Models\CarritoModel();
    $cartCount = $carritoModel->contarProductos($userId);
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand" href="<?= $isAdmin ? site_url('admin/principal') : site_url('/principal') ?>">
      <img src="/proyecto_taller/assets/img/canTfor.jpg" alt="Logo" height="40">
    </a>

    <!-- Botón para móviles -->
    <button class="navbar-toggler" type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarContent" 
            aria-controls="navbarContent" 
            aria-expanded="false" 
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Contenido del navbar -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Ítems del menú principal -->
        <li class="nav-item mx-2">
          <a class="nav-link <?= strpos($currentUrl, 'quienes_somos') ? 'active' : '' ?>" 
             href="<?= $isAdmin ? site_url('admin/quienes_somos') : site_url('quienes_somos') ?>">
            <i class="fas fa-info-circle me-1"></i> Quienes Somos
          </a>
        </li>

        <li class="nav-item mx-2">
          <a class="nav-link <?= strpos($currentUrl, 'comercializacion') ? 'active' : '' ?>" 
             href="<?= $isAdmin ? site_url('admin/comercializacion') : site_url('Comercializacion') ?>">
            <i class="fas fa-store me-1"></i> Comercialización
          </a>
        </li>

        <li class="nav-item mx-2">
          <a class="nav-link <?= strpos($currentUrl, 'contacto') ? 'active' : '' ?>" 
             href="<?= $isAdmin ? site_url('admin/contacto') : site_url('Contacto') ?>">
            <i class="fas fa-envelope me-1"></i> Contacto
          </a>
        </li>

        <li class="nav-item mx-2">
          <a class="nav-link <?= strpos($currentUrl, 'terminos') ? 'active' : '' ?>" 
             href="<?= $isAdmin ? site_url('admin/terminos_usos') : site_url('termino_usos') ?>">
            <i class="fas fa-file-alt me-1"></i> Términos
          </a>
        </li>

        <!-- Catálogo -->
        <?php if ($isAdmin): ?>
          <li class="nav-item mx-2">
            <a class="nav-link <?= strpos($currentUrl, 'admin/catalogo') ? 'active' : '' ?>" 
               href="<?= site_url('admin/catalogo') ?>">
              <i class="fas fa-box-open me-1"></i> Catálogo Admin
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item mx-2">
            <a class="nav-link <?= strpos($currentUrl, 'catalogo') ? 'active' : '' ?>" 
               href="<?= site_url('catalogo') ?>">
              <i class="fas fa-box-open me-1"></i> Catálogo
            </a>
          </li>
        <?php endif; ?>

        <!-- Mis Consultas (usuario normal) -->
        <?php if ($loggedIn && $rol === 'usuario'): ?>
          <li class="nav-item mx-2">
            <a class="nav-link <?= strpos($currentUrl, 'mis_consultas') ? 'active' : '' ?>" 
               href="<?= site_url('usuario/mis_consultas') ?>">
              <i class="fas fa-question-circle me-1"></i> Mis Consultas
            </a>
          </li>
        <?php endif; ?>
      </ul>

      <!-- Menú derecho -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php if ($loggedIn && $userId): ?>
          <li class="nav-item mx-2">
            <a class="nav-link position-relative" href="<?= site_url('carrito/usuario/'.$userId) ?>">
              <i class="fas fa-shopping-cart"></i>
              <?php if ($cartCount > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-counter">
                  <?= $cartCount ?>
                  <span class="visually-hidden">productos en el carrito</span>
                </span>
              <?php endif; ?>
            </a>
          </li>
        <?php endif; ?>

        <?php if (!$loggedIn): ?>
          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" 
               id="loginDropdown" role="button" 
               data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-sign-in-alt me-1"></i> Ingresar
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
              <li><a class="dropdown-item" href="<?= site_url('login') ?>"><i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión</a></li>
              <li><a class="dropdown-item" href="<?= site_url('register') ?>"><i class="fas fa-user-plus me-2"></i> Registrarse</a></li>
            </ul>
          </li>
        <?php else: ?>
          <!-- Panel Admin -->
          <?php if ($isAdmin): ?>
            <li class="nav-item dropdown mx-2">
              <a class="nav-link dropdown-toggle" href="#" 
                 id="adminDropdown" role="button" 
                 data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-tachometer-alt me-1"></i> Panel Admin
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                <li><a class="dropdown-item" href="<?= site_url('admin/panel') ?>"><i class="fas fa-plus-circle me-2"></i> Crear Producto</a></li>
                <li><a class="dropdown-item" href="<?= site_url('admin/productos') ?>"><i class="fas fa-list me-2"></i> Listar Productos</a></li>
                <li><a class="dropdown-item" href="<?= site_url('admin/consultas') ?>"><i class="fas fa-comments me-2"></i> Gestionar Consultas</a></li>
              </ul>
            </li>
          <?php endif; ?>

          <!-- Perfil y logout -->
          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" 
               id="userDropdown" role="button" 
               data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle me-1"></i> <?= esc($session->get('nombre')) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="<?= $isAdmin ? site_url('admin/perfil') : site_url('usuario/perfil') ?>"><i class="fas fa-user me-2"></i> Mi Perfil</a></li>
              <?php if ($isAdmin): ?>
                <li><a class="dropdown-item" href="<?= site_url('admin/configuracion') ?>"><i class="fas fa-cog me-2"></i> Configuración</a></li>
              <?php endif; ?>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="<?= site_url('logout') ?>" method="POST" class="d-inline">
                  <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión</button>
                </form>
              </li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
