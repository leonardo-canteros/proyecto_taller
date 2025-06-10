<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Catálogo de Productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?= base_url('css/catalogo.css') ?>" rel="stylesheet" />
</head>

<body>

<div class="container catalogo_producto-contenedor py-4">
  <h1 class="catalogo_producto-titulo mb-4 text-center">Catálogo de Productos</h1>

  <div id="catalogo_producto-lista" class="row g-4">
    <!-- Aquí se insertarán las cards de productos -->
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 const apiURL = '/proyecto_taller/public/productos';

$(document).ready(function() {
  $.getJSON(apiURL, function(data) {
    if (!data || data.length === 0) {
      $('#catalogo_producto-lista').html('<p class="text-center">No hay productos disponibles.</p>');
      return;
    }

    let productosVisibles = 0;

    data.forEach(producto => {
      // Mostrar solo productos activos y NO eliminados
      if (producto.estado === 'activo' && producto.deleted_at === null) {
        productosVisibles++;

        let descripcion = producto.descripcion || '';
        if (descripcion.length > 60) {
          descripcion = descripcion.substring(0, 57) + '...';
        }

        // Armar ruta completa para la imagen
            let imagen = producto.imagen?.startsWith('http') || producto.imagen?.startsWith('/assets/')
            ? producto.imagen
            : '/assets/' + producto.imagen;


        $('#catalogo_producto-lista').append(`
          <div class="col-md-4 col-sm-6">
            <div class="catalogo_producto-card shadow-sm h-100 d-flex flex-column">
              <img src="${imagen}" class="catalogo_producto-img" alt="${producto.nombre}">
              <div class="catalogo_producto-body d-flex flex-column flex-grow-1">
                <div>
                  <h5 class="catalogo_producto-nombre">${producto.nombre}</h5>
                  <p class="catalogo_producto-descripcion" title="${producto.descripcion}">${descripcion}</p>
                  <small>Color: ${producto.color || 'N/A'}</small><br/>
                  <small>Talla: ${producto.talla || 'N/A'}</small>
                </div>
                <div class="mt-auto catalogo_producto-precio">$${parseFloat(producto.precio).toFixed(2)}</div>
              </div>
            </div>
          </div>
        `);
      }
    });

    if (productosVisibles === 0) {
      $('#catalogo_producto-lista').html('<p class="text-center">No hay productos activos disponibles.</p>');
    }
  }).fail(function(jqXHR, textStatus, errorThrown) {
    $('#catalogo_producto-lista').html(`
      <p class="text-center text-danger">
        Error al cargar los productos: ${textStatus} - ${errorThrown}
      </p>
    `);
    console.error('Error en la petición AJAX:', textStatus, errorThrown);
    console.error('Respuesta del servidor:', jqXHR.responseText);
  });
});
</script>

</body>
</html>
