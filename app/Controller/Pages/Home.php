<?php

namespace App\Controller\Pages;

use App\Core\View;
use App\Controller\Pages\Gasto\GastoListagem;

class Home extends Page {

  public function getHome() {
    $obGastoListagem = new GastoListagem();
    
    $content = View::render('pages/home', [
      'gastosUltimosTrintaDias' => $obGastoListagem->getGastosUltimosTrintaDias(),
      'listagemGastos'          => $obGastoListagem->getListagemGastos()
    ]);
    return parent::getPage($content);
  }
}