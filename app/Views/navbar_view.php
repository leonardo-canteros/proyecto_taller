<?php
$session = session();
$loggedIn = $session->get('logged_in');
$rol = $session->get('rol');
?>

<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand me-auto barra" href="principal">
      <img src="/proyecto_taller/assets/img/canTfor.jpg" alt="Logo" height="40" class="logonav">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- Ítems comunes a todos -->
        <li class="nav-item">
          <a class="nav-link" href="quienes_somos">Quienes Somos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Comercializacion">Comercialización</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Contacto">Contacto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="termino_usos">Términos Y Usos</a>
        </li>

        <?php if (!$loggedIn): ?>
          <!-- No logueado -->
          <li class="nav-item">
            <a class="nav-link" href="register">Registrarse</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login">Ingresar</a>
          </li>
        <?php else: ?>
          <!-- Logueado -->
          
          <?php if ($rol === 'administrador'): ?>
            <!-- Menú adicional para administradores -->
            <li class="nav-item">
              <a class="nav-link" href="/admin/dashboard">Panel de administración</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/admin/usuarios">Gestión de usuarios</a>
            </li>
          <?php elseif ($rol === 'usuario'): ?>
            <!-- Menú adicional para usuarios comunes -->
              <a class="nav-link" href="/usuario/pedidos">Mis pedidos</a>
            </li>
          <?php endif; ?>

          <!-- Saludo y logout -->
          <li class="nav-item">
            <a class="nav-link" href="#">Hola, <?= esc($session->get('nombre')) ?></a>
          </li>
          <li class="nav-item">
            <form action="/proyecto_taller/public/logout" method="POST" class="d-inline">

              <button class="btn btn-link nav-link" type="submit" style="display:inline; padding:0; border:none; background:none;">Cerrar sesión</button>
            </form>
          </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
