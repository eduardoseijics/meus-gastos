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
    $gasto = ModelGasto::getGastos('data >= CURDATE() - INTERVAL 30 DAY;', null, null, 'SUM(valor) AS total');
    return $gasto->fetchObject()->total;
  }
}