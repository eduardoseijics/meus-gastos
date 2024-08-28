<?php

namespace App\Controller\Pages\CategoriaGasto;

use PDO;
use App\Core\View;
use App\Model\Entity\CategoriaGasto as ModelCategoriaGasto;

class CategoriaGastoListagem {
  
  public static function getCategoriaGastosListagem() : string {

    $arrCategoriaGasto = ModelCategoriaGasto::getCategoriaGastos()->fetchAll(PDO::FETCH_KEY_PAIR);
    $varsLayout = '';
    foreach($arrCategoriaGasto as $id => $categoriaGasto) {
      $varsLayout .= View::render('pages/components/categoria-gasto/listagem/categoria-gasto-listagem-item', [
        'itens' => ''
      ]);
    }
    return View::render('', [
      'itens' => $varsLayout
    ]);
  }
}