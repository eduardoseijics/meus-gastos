<?php

namespace App\Controller\Pages;

use App\Core\View;
use App\Model\Entity\Gasto as ModelGasto;

class Home extends Page {

  public static function getHome() {
    $content = View::render('pages/home', [
      'gastosUltimosTrintaDias' =>  self::getGastosUltimosTrintaDias()
    ]);
    return parent::getPage($content);
  }

  public static function getGastosUltimosTrintaDias() {
    $gasto = ModelGasto::getGastos('DATEDIFF(data_criacao, CURRENT_TIMESTAMP) BETWEEN 0 AND 30', null, null, 'SUM(valor) AS valor');
    return $gasto->fetchObject()->valor;
  }
}