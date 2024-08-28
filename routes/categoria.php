<?php 

use App\Http\Response;

$obRouter->get('/categorias', [
  function () {
    return new Response(200, CategoriasListagem::getCategorias());
  }
]);
