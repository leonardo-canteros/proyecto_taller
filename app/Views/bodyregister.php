<link rel="stylesheet" href="/proyecto_taller/assets/css/register.css">

<div class="registro_contenedor">
    <h2 class="registro_titulo">Registrar Usuario</h2>

    <form action="register" method="post" class="registro_formulario">

        <div class="registro_grupo">
            <label for="nombre" class="registro_label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="registro_input" required>
        </div>

        <div class="registro_grupo">
            <label for="apellido" class="registro_label">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="registro_input" required>
        </div>

        <div class="registro_grupo">
            <label for="correo" class="registro_label">Correo electrónico</label>
            <input type="email" name="correo" id="correo" class="registro_input" required>
        </div>

        <div class="registro_grupo">
            <label for="contraseña" class="registro_label">Contraseña</label>
            <input type="password" name="contraseña" id="contraseña" class="registro_input" required minlength="8">
        </div>

        <div class="registro_grupo">
            <label for="direccion" class="registro_label">Dirección</label>
            <input type="text" name="direccion" id="direccion" class="registro_input" required>
        </div>

        <div class="registro_grupo">
            <label for="telefono" class="registro_label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="registro_input" required>
        </div>

        <button type="submit" class="registro_boton">Registrarse</button>
    </form>
</div>
