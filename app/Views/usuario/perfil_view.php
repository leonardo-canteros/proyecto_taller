<main class="container my-5">
  <h2 class="mb-4 text-white text-center">Mi Perfil</h2>

  <div class="card mx-auto" style="max-width: 500px;">
    <div class="card-body">
      <h5 class="card-title"><?= esc($usuario['nombre']) ?> <?= esc($usuario['apellido']) ?></h5>
      <p class="card-text"><strong>Correo:</strong> <?= esc($usuario['correo']) ?></p>
      <p class="card-text"><strong>Dirección:</strong> <?= esc($usuario['direccion']) ?></p>
      <p class="card-text"><strong>Teléfono:</strong> <?= esc($usuario['telefono']) ?></p>

    </div>
  </div>
</main>
