<div class="container mt-5">
    <h1 class="mb-4">Panel de Administrador</h1>
    <p>Bienvenido, <?= esc(session('nombre')) ?>. Aquí puedes gestionar el sistema.</p>

    <ul>
        <li><a href="/productos">Gestionar productos</a></li>
        <li><a href="/usuarios">Gestionar usuarios</a></li>
        <!-- Agrega más enlaces administrativos aquí -->
    </ul>
</div>
