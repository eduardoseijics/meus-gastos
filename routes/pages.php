<?php

use App\Http\Response;
use App\Controller\Pages;
use App\Controller\Pages\Gasto\Gasto;

//ROTA HOME
$obRouter->get('/', [
  function() {
    return new Response(Response::HTTP_OK, Pages\Home::getHome());
  }
]);

//ROTA HOME
$obRouter->get('/adicionar-gasto', [
  function() {
    return new Response(Response::HTTP_OK, Pages\Gasto\GastoFormulario::getFormularioCriarGasto());
  }
]);

$obRouter->post('/adicionar-gasto', [
  function ($request) {
    return new Response(200, Gasto::criar($request));
  }
]);