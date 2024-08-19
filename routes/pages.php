<?php

use App\Http\Response;
use App\Controller\Pages;
use App\Controller\Pages\Page;

//ROTA HOME
$obRouter->get('/', [
  function() {
    return new Response(Response::HTTP_OK, Pages\Home::getHome());
  }
]);