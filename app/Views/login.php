<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/proyecto_taller/assets/css/login.css">
</head>
<body>

<div class="login_contenedor">
    <h2 class="login_titulo">Iniciar Sesión</h2>

    <!-- Mostrar mensajes flash -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alerta_exito"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alerta_error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('login') ?>" method="post" class="login_formulario">

        <div class="login_grupo">
            <label for="correo" class="login_label">Correo electrónico</label>
            <input type="email" name="correo" id="correo" class="login_input" required>
        </div>

        <div class="login_grupo">
            <label for="contraseña" class="login_label">Contraseña</label>
            <input type="password" name="contraseña" id="contraseña" class="login_input" required>
        </div>

        <button type="submit" class="login_boton">Ingresar</button>
    </form>
</div>

</body>
</html>
