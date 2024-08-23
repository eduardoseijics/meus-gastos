<?php

use App\Http\Response;
use App\Controller\Pages;
use App\Controller\Pages\Gasto\Gasto;
use App\Controller\Pages\Gasto\GastoListagem;

//ROTA HOME
$obRouter->get('/', [
  function() {
    return new Response(Response::HTTP_OK, (new Pages\Home)->getHome());
  }
]);

//ROTA HOME
$obRouter->get('/adicionar-gasto', [
  function() {
    return new Response(Response::HTTP_OK, Pages\Gasto\GastoFormulario::getFormularioCriarGasto());
  }
]);

//ROTA HOME
$obRouter->get('/gasto-por-categoria', [
  function() {
    return new Response(Response::HTTP_OK, (new GastoListagem)->getGastoPorCategoria());
  }
]);

$obRouter->post('/adicionar-gasto', [
  function ($request) {
    return new Response(200, Gasto::criar($request));
  }
]);