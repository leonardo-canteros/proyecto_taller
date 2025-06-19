<div class="container mt-5">

    <p>Bienvenido<?= esc(session('nombre')) ?>. Aquí puedes ver tus datos y explorar nuestros productos.</p>

    <ul>
        <a href="<?= site_url('catalogo') ?>">Ver productos</a>

        <li><a href="/perfil">Editar perfil</a></li>
        <!-- Agrega más opciones para el usuario aquí -->
    </ul>
</div>
