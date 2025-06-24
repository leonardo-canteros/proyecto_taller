<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? esc($title) : 'Costura Fina' ?></title>

  <!-- Google Fonts: Montserrat para menús, Playfair Display para títulos -->
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Playfair+Display:wght@400;600;700&display=swap"
    rel="stylesheet"
  >

  <!-- Bootstrap CSS -->
  <link href="/proyecto_taller/assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap CSS -->


  <!-- Font Awesome -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
  >

  <!-- Tus estilos personalizados -->
  <link href="/proyecto_taller/assets/css/styles.css"    rel="stylesheet">
  <link href="/proyecto_taller/assets/css/formuProdu.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/carritofierrito.css">

  <!-- Si tienes un navbar.css específico, lo incluirías aquí: -->
  <!-- <link href="/proyecto_taller/assets/css/navbar.css" rel="stylesheet"> -->

  <!-- Favicon -->
  <link
    rel="icon"
    href="/proyecto_taller/assets/img/canTfor.jpg"
    type="image/x-icon"
  >

  <!-- Forzar fuente Montserrat en todo el body -->
  <style>
    body { font-family: 'Montserrat', sans-serif; }
    h1,h2,h3,h4,h5 { font-family: 'Playfair Display', serif; }
  </style>
</head>
<body>
  <header>
    <img
      class="logo img-fluid"
      src="/proyecto_taller/assets/img/canTfor.jpg"
      alt="Logo de la empresa"
    >
  </header>
