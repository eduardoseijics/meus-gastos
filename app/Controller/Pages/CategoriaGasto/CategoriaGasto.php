<?php

namespace App\Controller\Pages\CategoriaGasto;

use PDO;
use App\Model\Entity\CategoriaGasto as ModelCategoriaGasto;

class CategoriaGasto {
  
  public static function getCategoriaGastos() : array {

    $arrCategoriaGasto = ModelCategoriaGasto::getCategoriaGastos()->fetchAll(PDO::FETCH_KEY_PAIR);
    return is_array($arrCategoriaGasto) ? $arrCategoriaGasto : [];
  }
}