<?php
$session    = session();
$loggedIn   = $session->get('logged_in');
$rol        = $session->get('rol');
$isAdmin    = ($loggedIn && $rol === 'administrador');
$isUser     = ($loggedIn && $rol === 'usuario');
$currentUrl = current_url();

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
    <a class="navbar-brand" href="<?= $isAdmin ? site_url('admin/principal') : ($isUser ? site_url('usuario/principal') : site_url('/principal')) ?>">
      <img src="/proyecto_taller/assets/img/canTfor.jpg" alt="Logo" height="40">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarContent" aria-controls="navbarContent"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2">
          <a class="nav-link <?= strpos($currentUrl, 'quienes_somos') ? 'active' : '' ?>"
             href="<?= $isAdmin ? site_url('admin/quienes_somos') : ($isUser ? site_url('usuario/quienes_somos') : site_url('quienes_somos')) ?>">
            <i class="fas fa-info-circle me-1"></i> Quienes Somos
          </a>
        </li>

        <li class="nav-item mx-2">
          <a class="nav-link <?= strpos($currentUrl, 'comercializacion') ? 'active' : '' ?>"
             href="<?= $isAdmin ? site_url('admin/comercializacion') : ($isUser ? site_url('usuario/comercializacion') : site_url('Comercializacion')) ?>">
            <i class="fas fa-store me-1"></i> Comercialización
          </a>
        </li>

        <?php if ($isUser): ?>
          <li class="nav-item mx-2">
            <a class="nav-link <?= strpos($currentUrl, 'usuario/consultas') ? 'active' : '' ?>"
               href="<?= site_url('usuario/consultas') ?>">
              <i class="fas fa-envelope me-1"></i> Consultas
            </a>
          </li>
        <?php elseif (!$loggedIn): ?>
          <li class="nav-item mx-2">
            <a class="nav-link <?= strpos($currentUrl, 'Contacto') ? 'active' : '' ?>"
               href="<?= site_url('Contacto') ?>">
              <i class="fas fa-envelope me-1"></i> Contacto
            </a>
          </li>
        <?php endif; ?>

        <li class="nav-item mx-2">
          <a class="nav-link <?= strpos($currentUrl, 'termino_usos') ? 'active' : '' ?>"
             href="<?= $isAdmin ? site_url('admin/terminos_usos') : ($isUser ? site_url('usuario/termino_usos') : site_url('termino_usos')) ?>">
            <i class="fas fa-file-alt me-1"></i> Términos
          </a>
        </li>

        <li class="nav-item mx-2">
          <a class="nav-link <?= strpos($currentUrl, 'catalogo') ? 'active' : '' ?>"
             href="<?= $isAdmin ? site_url('admin/catalogo') : ($isUser ? site_url('usuario/catalogo') : site_url('catalogo')) ?>">
            <i class="fas fa-box-open me-1"></i> Catálogo
          </a>
        </li>

        <?php if ($isUser): ?>
          <li class="nav-item mx-2">
            <a class="nav-link <?= strpos($currentUrl, 'mis_consultas') ? 'active' : '' ?>"
               href="<?= site_url('usuario/mis_consultas') ?>">
              <i class="fas fa-question-circle me-1"></i> Mis Consultas
            </a>
          </li>
        <?php endif; ?>
      </ul>

      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php if ($loggedIn && $userId): ?>
          <li class="nav-item mx-2">
            <a class="nav-link position-relative" href="<?= site_url('carrito/usuario/'.$userId) ?>">
              <i class="fas fa-shopping-cart"></i>
              <?php if ($cartCount > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-counter">
                <?= $cartCount ?>
              </span>
              <?php endif; ?>
            </a>
          </li>
        <?php endif; ?>

        <?php if (!$loggedIn): ?>
          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown">
              <i class="fas fa-sign-in-alt me-1"></i> Ingresar
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="<?= site_url('login') ?>"><i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión</a></li>
              <li><a class="dropdown-item" href="<?= site_url('register') ?>"><i class="fas fa-user-plus me-2"></i> Registrarse</a></li>
            </ul>
          </li>
        <?php else: ?>
          <?php if ($isAdmin): ?>
            <li class="nav-item dropdown mx-2">
              <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-tachometer-alt me-1"></i> Panel Admin
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?= site_url('admin/panel') ?>"><i class="fas fa-plus-circle me-2"></i> Crear Producto</a></li>
                <li><a class="dropdown-item" href="<?= site_url('admin/productos') ?>"><i class="fas fa-list me-2"></i> Listar Productos</a></li>
                <li><a class="dropdown-item" href="<?= site_url('admin/consultas') ?>"><i class="fas fa-comments me-2"></i> Gestionar Consultas</a></li>
                <li><a class="dropdown-item" href="<?= site_url('admin/contacto') ?>"><i class="fas fa-inbox me-2"></i> Ver Contactos</a></li>
                <li><a class="dropdown-item" href="<?= site_url('admin/usuarios') ?>"><i class="fas fa-users me-2"></i> Gestionar Usuarios</a></li>
              </ul>
            </li>
          <?php endif; ?>

          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
              <i class="fas fa-user-circle me-1"></i> <?= esc($session->get('nombre')) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
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
