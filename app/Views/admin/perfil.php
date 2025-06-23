<main class="container my-5">
    <h1 class="text-center text-white mb-4">Perfil del Administrador</h1>

    <div class="card mx-auto shadow" style="max-width: 400px;">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-user-shield me-2"></i> <?= esc($usuario['nombre']) ?>
        </div>
        <div class="card-body">
            <p><strong>Apellido:</strong> <?= esc($usuario['apellido'] ?? '-') ?></p>
            <p><strong>Correo:</strong> <?= esc($usuario['correo']) ?></p>
            <p><strong>Teléfono:</strong> <?= esc($usuario['telefono'] ?? '-') ?></p>
            <p><strong>Dirección:</strong> <?= esc($usuario['direccion'] ?? '-') ?></p>
            <p><strong>Rol:</strong> <?= esc($usuario['rol']) ?></p>
        </div>
    </div>
</main>
