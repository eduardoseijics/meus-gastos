<?php 

use App\Http\Response;
use App\Controller\Admin\Admin;
use App\Controller\Admin\Usuarios\Usuarios;
use App\Controller\Admin\Usuarios\UsuariosListagem;
use App\Controller\Admin\Usuarios\UsuariosFormulario;

// Inclui a rota home de admin
include_once __DIR__ . '/login.php';

// Rota admin
$obRouter->get('/admin', [
  'middlewares' => ['required-admin-login'],
  function () {
    return new Response(200, Admin::getHome());
  }
]);



