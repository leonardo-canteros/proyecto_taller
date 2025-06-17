<div class="container mt-5">

    <p>Bienvenido<?= esc(session('nombre')) ?>. Aquí puedes ver tus datos y explorar nuestros productos.</p>

    <ul>
        <li><a href="/productos">Ver productos</a></li>
        <li><a href="/perfil">Editar perfil</a></li>
        <!-- Agrega más opciones para el usuario aquí -->
    </ul>
</div>
